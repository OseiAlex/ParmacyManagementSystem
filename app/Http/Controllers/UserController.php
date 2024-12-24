<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function index()
    {
        return Inertia::render('Admin/User');
    }

    public function fetch(Request $request)
    {
        $data = User::get(['id', 'name', 'username', 'email', 'phone', 'is_admin']);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('role', function ($row) {
                return $row->is_admin ? 'Administrator' : 'Pharmacist';
            })
            ->addColumn('action', function ($row) {
                $linkClass = 'inline-flex items-center w-full px-4 py-2 text-sm text-gray-700 disabled:cursor-not-allowed disabled:opacity-25 hover:text-gray-50 hover:bg-gray-100';

                $action =
                    '<div class="relative inline-block text-left">
                        <div class="flex justify-end">
                          <button type="button" class="dropdown-toggle py-2 rounded-md">
                          <span class="material-symbols-outlined dropdown-span" dropdown-log="' . $row->id . '">
                            more_vert
                          </span> 
                          </button>
                        </div>

                        <div id="dropdown-menu-' . $row->id . '" class="hidden dropdown-menu absolute right-0 z-10 mt-2 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                            <button type="button" data-id="' . $row->id . '" class="edit ' . $linkClass . '">
                                Edit
                            </button>
                            <button type="button" data-id="' . $row->id . '" class="reset ' . $linkClass . '">
                                Reset Password
                            </button>
                            <button type="button" data-id="' . $row->id . '" class="delete ' . $linkClass . '">
                                 Delete
                            </button>
                        </div>
                      </div>
                      ';

                return $action;
            })
            ->rawColumns(['role', 'action'])
            ->make(true);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'username' => ['required', 'string', 'max:255', Rule::unique(User::class)],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)],
                'phone' => ['required', 'digits:10', Rule::unique(User::class)],
                'is_admin' => ['nullable'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]
        );

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        User::create($input);
    }

    public function editProfile(Request $request)
    {
        $data = User::find($request->id);
        $data['is_admin'] = $data['is_admin'] == 1 ? true : false;

        return response()->json([
            'row'   => $data
        ]);
    }

    public function updateProfile(Request $request, User $user)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'username' => ['required', 'string', 'max:255', Rule::unique(User::class)->ignore($user)],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user)],
                'phone' => ['required', 'digits:10', Rule::unique(User::class)->ignore($user)],
                'is_admin' => ['nullable']
            ],
        );

        $input = $request->all();

        $user->fill($input)->save();
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($request->password);

        $user->fill($input)->save();
    }

    public function destroy(Request $request)
    {
        $data = User::find($request->id);

        $data->delete();
    }
}
