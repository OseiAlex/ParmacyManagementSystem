<?php

namespace App\Http\Controllers;

use App\Models\PaymentMode;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Yajra\DataTables\Facades\DataTables;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::where('is_delisted', false)
            ->orderBy('name')
            ->where('stock_level_at_dispensary', '>=', 1)
            ->whereDate('expires_at', '>', Carbon::now())
            ->get(['id', 'name', 'selling_price', 'stock_level_at_dispensary']);

        $users = User::orderBy('name')->get(['uuid', 'name']);

        $pays = PaymentMode::get(['id', 'title']);
        return Inertia::render((Auth::user()->is_admin ? 'Admin/' : 'Dispensary/') . 'Sales', compact(
            'pays',
            'products',
            'users'
        ));
    }

    public function fetch(Request $request)
    {
        $filter = $request->filter;
        $start_at = $filter['start_at'];
        $end_at = $filter['end_at'];
        $sp = Auth::user()->is_admin ? $filter['user'] : Auth::user()->uuid;

        $data = Sale::with('user', 'payment_mode')
            ->when($start_at, function ($q, $start_at) {
                $q->whereDate('updated_at', '>=', Carbon::parse($start_at));
            })
            ->when($end_at, function ($q, $end_at) {
                $q->whereDate('updated_at', '<=', Carbon::parse($end_at));
            })
            ->when($sp, function ($q, $sp) {
                $user = User::where('uuid', $sp)->first();
                $q->where('user_id', $user->id);
            })
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('date', function ($row) {
                return '<span class="hidden">' . strtotime($row->created_at) . '</span>' . Carbon::parse($row->created_at)->format('d/m/Y');
            })
            ->addColumn('user', function ($row) {
                return $row->user->name;
            })
            ->addColumn('pay_mode', function ($row) {
                return $row->payment_mode->title;
            })
            ->editColumn('amount_debt', function ($row) {
                return '<p class="' . ($row->amount_debt < 0 ? 'text-red-600 ' : '') . '">' . sprintf('%.2f', abs((float) $row->amount_debt)) . '</p>';
            })
            ->addColumn('action', function ($row) {
                $linkClass = 'inline-flex items-center w-full px-4 py-2 text-sm text-gray-700 disabled:cursor-not-allowed disabled:opacity-25 hover:text-gray-50 hover:bg-gray-100';

                $action = '<div class="relative inline-block text-left">
                        <div class="flex justify-end">
                          <button type="button" class="dropdown-toggle py-2 rounded-md border border-transparent">
                          <span class="material-symbols-outlined dropdown-span" dropdown-log="' . $row->uuid . '">
                            more_vert
                          </span> 
                          </button>
                        </div>

                        <div id="dropdown-menu-' . $row->uuid . '" class="hidden dropdown-menu absolute right-0 z-10 mt-2 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                            <button type="button" data-id="' . $row->uuid . '" class="edit ' . $linkClass . '">
                                Edit 
                            </button>
                            <button type="button" data-id="' . $row->uuid . '" class="delete ' . $linkClass . '">
                                Delete 
                            </button>
                        </div>
                      </div>';
                return $action;
            })
            ->rawColumns(['date', 'amount_debt', 'action']) // Ensure the HTML is rendered correctly
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:100'],
                'payment_mode_id' => ['required'],
                'products.*.qty' => ['required', 'numeric', 'min:1'],
                'amount_paid' => ['required', 'numeric', 'min:0'],
            ],
            [
                'payment_mode_id.required' => 'The payment mode field is required.',
                'products.*.qty.required'  => 'The quantity field is required.',
                'products.*.qty.numeric' => 'The quantity must be a number.',
                'products.*.qty.min' => 'The quantity must be at least :min.',
            ]
        );

        $input = $request->all();
        $totalAmountDue = 0;

        foreach ($input['products'] as $product) {
            $p = Product::find($product['product_id']);
            $totalAmountDue += $p->selling_price * $product['qty'];
        }

        $input['amount_due'] = $totalAmountDue;
        $input['amount_debt'] = $totalAmountDue - $input['amount_paid'];

        $sales = new Sale($input);

        $data = Auth::user()->sale()->save($sales);

        $productData = [];
        foreach ($input['products'] as $product) {
            $productData[$product['product_id']] = ['qty' => $product['qty']];
        }

        $data->product()->sync($productData);

        foreach ($input['products'] as $product) {
            $p = Product::find($product['product_id']);
            $p->decrement('stock_level_at_dispensary', $product['qty']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $uuid = $request->uuid;
        $data = Sale::where('uuid', $uuid)
            ->with(['product:id,name,selling_price,stock_level_at_dispensary'])  // Directly specify columns to fetch
            ->first();

        return response()->json([
            'row' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $sale = Sale::where('uuid', $uuid)->first();

        $request->validate(
            [
                'name' => ['required', 'string', 'max:100'],
                'payment_mode_id' => ['required'],
                'products.*.qty' => ['required', 'numeric', 'min:1'],
                'amount_paid' => ['required', 'numeric', 'min:0'],
            ],
            [
                'payment_mode_id.required' => 'The payment mode field is required.',
                'products.*.qty.required'  => 'The quantity field is required.',
                'products.*.qty.numeric' => 'The quantity must be a number.',
                'products.*.qty.min' => 'The quantity must be at least :min.',
            ]
        );

        $input = $request->all();
        $totalAmountDue = 0;

        foreach ($input['products'] as $product) {
            $p = Product::find($product['product_id']);
            $totalAmountDue += $p->selling_price * $product['qty'];
        }

        $input['amount_due'] = $totalAmountDue;
        $input['amount_debt'] = $totalAmountDue - $input['amount_paid'];
        $input['user_id'] = Auth::id();

        $sale->fill($input)->save();

        $productData = [];
        foreach ($input['products'] as $product) {
            $productData[$product['product_id']] = ['qty' => $product['qty']];
        }

        $sale->product()->sync($productData);

        foreach ($input['products'] as $product) {
            $newStockLevel = $p->stock_level_at_dispensary - $product['qty'];

            if ($newStockLevel >= 0) {
                $p->decrement('stock_level_at_dispensary', $product['qty']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $uuid = $request->uuid;
        $data = Sale::where('uuid', $uuid)->first();

        $data->delete();
    }
}
