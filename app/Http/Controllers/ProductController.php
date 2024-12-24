<?php

namespace App\Http\Controllers;

use App\Imports\ProductImport;
use App\Models\MeasuringUnit;
use App\Models\Product;
use App\Models\ProductCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\HeadingRowImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = ProductCategory::orderBy('title')->get(['id', 'title']);
        $units = MeasuringUnit::orderBy('title')->get(['id', 'title']);
        return Inertia::render('Admin/Inventory/Product', compact('categories', 'units'));
    }

    public function fetch(Request $request)
    {
        $filter = $request->filter;

        $data = Product::when($filter, function ($q, $filter) {
            $q->where('is_delisted', filter_var($filter, FILTER_VALIDATE_BOOLEAN));
        })->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                return '<span class="px-3 py-1 ' . ($row->is_delisted ? 'bg-red-600 ' : 'bg-purple-600 ') . ' text-xs rounded-md leading-none text-center capitalize whitespace-nowrap font-semibold text-white">' .
                    ($row->is_delisted ? 'Delisted' : 'Available') .
                    '</span>';
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
                            <button type="button" data-id="' . $row->uuid . '" class="' . ($row->is_delisted ? 'restore ' : 'delist ') . $linkClass . '">' .
                    ($row->is_delisted ? 'Restore' : 'Delist') .
                    '</button>
                            <button type="button" data-id="' . $row->uuid . '" class="delete ' . $linkClass . '">
                                Delete
                            </button>
                        </div>
                      </div>';
                return $action;
            })
            ->rawColumns(['status', 'action']) // Ensure the HTML is rendered correctly
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->validate(
            [
                'name' => ['required', 'string', 'max:100', Rule::unique(Product::class)],
                'generic_name' => ['nullable', 'string', 'max:100'],
                'manufacturer' => ['nullable', 'string', 'max:100'],
                'product_category_id' => ['required'],
                'measuring_unit_id' => ['required'],
                'cost_price' => ['required', 'numeric', 'min:0'],
                'discount' => ['nullable', 'numeric', 'min:0', 'max: 100'],
                'markup_percentage' => ['nullable', 'numeric', 'min:0', 'max: 100'],
                'restock_level_at_dispensary' => ['required', 'numeric', 'min:0'],
                'restock_level_at_store' => ['required', 'numeric', 'min:0'],
                'expires_at' => ['required', 'date'],
            ],
            [
                'product_category_id.required' => 'The product category field is required.',
                'measuring_unit_id.required' => 'The measuring unit field is required.'
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

        Product::create($input);
    }

    public function import(Request $request)
    {
        $file = $request->file;

        // Validate the import file
        $validator = Validator::make(['file' => $file], [
            'file' => 'required|file|mimes:xls,csv,txt', // Add any validation rules you need
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400); // Return validation errors
        }

        $headingRow = (new HeadingRowImport)->toArray($file);

        $headings = $headingRow[0][0];

        // Define the expected headers with corresponding column letters.
        $headers = [
            'A' => 'product_name',
            'B' => 'generic_name',
            'C' => 'manufacturer',
            'D' => 'category',
            'E' => 'unit',
            'F' => 'cost_price',
            'G' => 'discount',
            'H' => 'markup_percentage',
            'I' => 'quantity_at_dispensary',
            'J' => 'quantity_at_store',
            'K' => 'expiry_date'
        ];

        $headingErrorMsg = [];

        foreach ($headings as $key => $heading) {
            // Convert the 0-based index to a column letter (e.g., 0 becomes 'A', 1 becomes 'B', etc.).
            $column = chr(ord('A') + $key);
            $expectedHeader = $headers[$column];

            if ($heading === null || is_numeric($heading)) {
                $headingErrorMsg[] = "Column {$column} in the provided spreadsheet does not match column {$column} of the import template. This column must be \"{$expectedHeader}\" and is required to be present.";
            } else if ($heading !== $headers[$column]) {
                $headingErrorMsg[] = "Column {$column} in the provided spreadsheet does not match column {$column} of the import template. This column must be \"{$expectedHeader}\" and the value provided was \"" .  $heading . '".';
            }

            if ($key === count($headers) - 1) {
                break;
            }
        }

        $validHeaders = array_filter($headings, function ($header) {
            return !is_numeric($header);
        });

        $headingCount = count($validHeaders);

        if ($headingCount > count($headers)) {
            $action = 'remove';
        } else {
            $action = 'add';
        }

        if ($headingCount !== count($headers)) {
            // Calculate the expected column count
            $expectedColumnCount = count($headers);

            // Determine if 'column' should be plural
            $plural = $expectedColumnCount !== 1 ? 's' : '';

            // Construct the error message using concatenation
            $msg = 'The spreadsheet should have exactly ' . $expectedColumnCount . ' column' . $plural . '. The provided spreadsheet has ' . number_format($headingCount) . ' columns. Please reference the import template and ' . $action . ' all additional columns from your spreadsheet.';

            // Add the error message to the array
            array_push($headingErrorMsg, $msg);
        }

        if (!empty($headingErrorMsg)) {

            return response()->json([
                'message' => 'The header row of your import file does not match the required header. The header row must exactly match the header of the import template (' . implode(', ', $headers) . ').',
                'header_errors' => $headingErrorMsg
            ], 412);
        }

        try {
            Excel::import(new ProductImport, $file);
        } catch (ValidationException $e) {
            $failures = $e->failures();

            $failedRows = [];

            if (!empty($failures)) {
                foreach ($failures as $failure) {
                    $errorRow = $failure->row();
                    $errorMsg = $failure->errors();

                    if (array_key_exists($errorRow, $failedRows)) {
                        $failedRows[$errorRow] = array_merge($failedRows[$errorRow], $errorMsg);
                    } else {
                        $failedRows[$errorRow] = $errorMsg;
                    }
                }

                return response()->json([
                    'message' => 'There are validation errors in your import file.',
                    'failed_rows' => $failedRows
                ], 412);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function edit(Request $request)
    {
        $uuid = $request->uuid;

        $data = Product::where('uuid', $uuid)->first();
        $data->expires_at = Carbon::parse($data->expires_at)->format('Y-m-d');

        return response()->json([
            'row'   => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        $product = Product::where('uuid', $uuid)->first();

        $input = $request->validate(
            [
                'name' => ['required', 'string', 'max:100', Rule::unique(Product::class)->ignore($product)],
                'generic_name' => ['nullable', 'string', 'max:100'],
                'manufacturer' => ['nullable', 'string', 'max:100'],
                'product_category_id' => ['required'],
                'measuring_unit_id' => ['required'],
                'cost_price' => ['required', 'numeric', 'min:0'],
                'discount' => ['nullable', 'numeric', 'min:0', 'max: 100'],
                'markup_percentage' => ['nullable', 'numeric', 'min:0', 'max: 100'],
                'restock_level_at_dispensary' => ['required', 'numeric', 'min:0'],
                'restock_level_at_store' => ['required', 'numeric', 'min:0'],
                'expires_at' => ['required', 'date'],
            ],
            [
                'product_category_id.required' => 'The product category field is required.',
                'measuring_unit_id.required' => 'The measuring unit field is required.'
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

    public function enlist(Request $request)
    {
        $uuid = $request->uuid;
        $data = Product::where('uuid', $uuid)->first();

        $input['is_delisted'] = !$data->is_delisted;

        $data->fill($input)->save();

        return response()->json([
            'message' => 'Product successfully ' . ($input['is_delisted'] ? 'delisted' : 'restored')
        ]);
    }

    public function destroy(Request $request)
    {
        $uuid = $request->uuid;
        $data = Product::where('uuid', $uuid)->first();

        $data->delete();
    }
}
