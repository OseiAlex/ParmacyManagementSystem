<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\MeasuringUnit;
use App\Models\Supplier;
use App\Models\SupplierCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = Country::orderBy('name')->get(['id', 'name']);
        return Inertia::render('Admin/Setup/Supplier', compact('countries'));
    }

    public function fetch()
    {

        $data = Supplier::with('country')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('country', function ($row) {
                return $row->country->name;
            })
            ->addColumn('action', function ($row) {
                $linkClass = 'inline-flex items-center w-full px-4 py-2 text-sm text-gray-700 disabled:cursor-not-allowed disabled:opacity-25 hover:text-gray-50 hover:bg-gray-100';

                $action =
                    '<div class="relative inline-block text-left">
                        <div class="flex justify-end">
                          <button type="button" class="dropdown-toggle py-2 rounded-md">
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
                      </div>
                      ';

                return $action;
            })
            ->rawColumns(['country', 'action'])
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
        $request->validate(
            [
                'company_name' => ['required', 'string', 'max:100', Rule::unique(Supplier::class)],
                'country_id' => ['required'],
                'email' => ['nullable', 'string', 'lowercase', 'email', 'max:255', Rule::unique(Supplier::class)],
                'phone' => ['required', 'min_digits:10', Rule::unique(Supplier::class)],
                'person_name' => ['required', 'string', 'max:100'],
                'person_email' => ['nullable', 'string', 'lowercase', 'email', 'max:255', Rule::unique(Supplier::class)],
                'person_phone' => ['required', 'min_digits:10', Rule::unique(Supplier::class)],
                'tin' => ['nullable', 'string', 'max:100', Rule::unique(Supplier::class)],
            ],
            [
                'country_id.required' => 'The country field is required.'
            ]
        );

        $input = $request->all();

        Supplier::create($input);
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

        $data = Supplier::where('uuid', $uuid)->first();

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
        $supplier = Supplier::where('uuid', $uuid)->first();

        $request->validate(
            [
                'company_name' => ['required', 'string', 'max:100', Rule::unique(Supplier::class)->ignore($supplier)],
                'country_id' => ['required'],
                'email' => ['nullable', 'string', 'lowercase', 'email', 'max:255', Rule::unique(Supplier::class)->ignore($supplier)],
                'phone' => ['required', 'min_digits:10', Rule::unique(Supplier::class)->ignore($supplier)],
                'person_name' => ['required', 'string', 'max:100'],
                'person_email' => ['nullable', 'string', 'lowercase', 'email', 'max:255', Rule::unique(Supplier::class)->ignore($supplier)],
                'person_phone' => ['required', 'min_digits:10', Rule::unique(Supplier::class)->ignore($supplier)],
                'tin' => ['nullable', 'string', 'max:100', Rule::unique(Supplier::class)->ignore($supplier)],
            ],
            [
                'country_id.required' => 'The country field is required.'
            ]
        );

        $input = $request->all();

        $supplier->fill($input)->save();
    }

    public function destroy(Request $request)
    {
        $uuid = $request->uuid;
        $data = Supplier::where('uuid', $uuid)->first();

        $data->delete();
    }
}
