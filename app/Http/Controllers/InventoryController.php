<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Yajra\DataTables\Facades\DataTables;

class InventoryController extends Controller
{
    public function showStockLevel()
    {
        return Inertia::render((Auth::user()->is_admin ? 'Admin/' : 'Dispensary/') . 'Inventory/StockLevel');
    }

    public function fetchProducts(Request $request)
    {
        $filter = $request->filter;
        $level = $filter['level'];
        $location = $filter['location'];

        $data = Product::where('is_delisted', false)
            ->when($level === 'in', function ($q) use ($location) {
                $q->where(function ($query) use ($location) {
                    if ($location === 'dispensary' || $location === 'all') {
                        $query->orWhere('stock_level_at_dispensary', '>', 0);
                    }
                    if ($location === 'store' || $location === 'all') {
                        $query->orWhere('stock_level_at_store', '>', 0);
                    }
                });
            })
            ->when($level === 'out', function ($q) use ($location) {
                $q->where(function ($query) use ($location) {
                    if ($location === 'dispensary' || $location === 'all') {
                        $query->orWhere('stock_level_at_dispensary', 0);
                    }
                    if ($location === 'store' || $location === 'all') {
                        $query->orWhere('stock_level_at_store', 0);
                    }
                });
            })
            ->when($level === 'all', function ($q) use ($location) {
                $q->where(function ($query) use ($location) {
                    if ($location === 'dispensary' || $location === 'all') {
                        $query->orWhere('stock_level_at_dispensary', '>=', 0);
                    }
                    if ($location === 'store' || $location === 'all') {
                        $query->orWhere('stock_level_at_store', '>=', 0);
                    }
                });
            })
            ->get(['uuid', 'name', 'stock_level_at_dispensary', 'stock_level_at_store']);

        return DataTables::of($data)
            ->addIndexColumn()
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
                            <button type="button" data-id="' . $row->uuid . '" class="stock ' . $linkClass . '">
                                Take Stock 
                            </button>
                        </div>
                      </div>';
                return $action;
            })
            ->rawColumns(['action']) // Ensure the HTML is rendered correctly
            ->make(true);
    }

    public function stockLevelEdit(Request $request)
    {
        $uuid = $request->uuid;

        $data = Product::where('uuid', $uuid)->first();

        $data['physical_stock_level_at_dispensary'] = $data['computed_stock_level_at_dispensary'] = $data['stock_level_at_dispensary'];
        $data['physical_stock_level_at_store'] = $data['computed_stock_level_at_store'] = $data['stock_level_at_store'];

        return response()->json([
            'row'   => $data
        ]);
    }

    public function stockLevelUpdate(Request $request, $uuid)
    {
        $product = Product::where('uuid', $uuid)->first();

        $request->validate(
            [
                'physical_stock_level_at_dispensary' => ['required', 'numeric', 'min:0'],
                'physical_stock_level_at_store' => ['required', 'numeric', 'min:0']
            ]
        );

        $input = $request->all();

        $input['stock_level_at_dispensary'] = $input['physical_stock_level_at_dispensary'];
        $input['stock_level_at_store'] = $input['physical_stock_level_at_store'];

        $product->fill($input)->save();
    }

    public function showPricing()
    {
        return Inertia::render((Auth::user()->is_admin ? 'Admin/' : 'Dispensary/') . 'Inventory/Pricing');
    }

    public function fetchPricingProducts(Request $request)
    {
        $data = Product::where('is_delisted', false)->get(['uuid', 'name', 'cost_price', 'markup_percentage', 'discount', 'selling_price']);

        return DataTables::of($data)
            ->addIndexColumn()
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
                        </div>
                      </div>';
                return $action;
            })
            ->rawColumns(['action']) // Ensure the HTML is rendered correctly
            ->make(true);
    }
    public function pricingEdit(Request $request)
    {
        $uuid = $request->uuid;

        $data = Product::where('uuid', $uuid)->first(['uuid', 'name', 'cost_price', 'markup_percentage', 'discount', 'selling_price']);

        return response()->json([
            'row'   => $data
        ]);
    }

    public function pricingUpdate(Request $request, $uuid)
    {
        $product = Product::where('uuid', $uuid)->first();

        $input = $request->validate(
            [
                'cost_price' => ['required', 'numeric', 'min:0'],
                'discount' => ['nullable', 'numeric', 'min:0', 'max: 100'],
                'markup_percentage' => ['nullable', 'numeric', 'min:0', 'max: 100'],
            ]
        );

        $cost_price = $input['cost_price'];
        $markup_percent = $input['markup_percentage'] = $input['markup_percentage'] ?? 0;
        $discount = $input['discount'] = $input['discount'] ?? 0;

        $markup_amount = ($markup_percent / 100) * $cost_price;

        $selling_price = $markup_amount + $cost_price;

        $discount_amount = ($discount / 100) * $selling_price;
        $selling_price -= $discount_amount;

        $input['selling_price'] = $selling_price;

        $product->fill($input)->save();
    }
    public function showExpiryProducts()
    {
        return Inertia::render((Auth::user()->is_admin ? 'Admin/' : 'Dispensary/') . 'Inventory/ExpiryProduct');
    }

    public function fetchExpiredProducts(Request $request)
    {
        $data = Product::where('is_delisted', false)
            ->whereDate('expires_at', '<=', Carbon::now())
            ->get(['name', 'stock_level_at_dispensary', 'stock_level_at_store', 'expires_at']);

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('expires_at', function ($row) {
                return Carbon::parse($row->expires_at)->format('d/m/Y');
            })
            ->rawColumns(['expires_at']) // Ensure the HTML is rendered correctly
            ->make(true);
    }

    // public function showTopProducts()
    // {
    //     return Inertia::render('Admin/Inventory/TopProduct');
    // }

    // public function fetchTopProducts(Request $request)
    // {
    //     $data = Product::where('is_delisted', false)
    //         ->whereDate('expires_at', '<=', Carbon::now())
    //         ->withCount('sales')
    //         ->get(['name', 'expires_at']);

    //     return DataTables::of($data)
    //         ->addIndexColumn()
    //         ->editColumn('expires_at', function($row) {
    //             return Carbon::parse($row->expires_at)->format('d/m/Y');
    //         })
    //         ->rawColumns(['expires_at']) // Ensure the HTML is rendered correctly
    //         ->make(true);
    // }
}
