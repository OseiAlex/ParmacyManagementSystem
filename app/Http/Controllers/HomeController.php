<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $admins = User::where('is_admin', true)->count();
        $pharmacists = User::where('is_admin', false)->count();
        $products = Product::where('is_delisted', false)
            ->whereDate('expires_at', '>', Carbon::now())
            ->count();
        $expiredProducts = Product::where('is_delisted', false)
            ->whereDate('expires_at', '<=', Carbon::now())
            ->count();

        $dispensaryShortage = Product::where('is_delisted', false)
            ->whereDate('expires_at', '>', Carbon::now())
            ->where('stock_level_at_dispensary', 0)
            ->count();

        $storeShortage = Product::where('is_delisted', false)
            ->whereDate('expires_at', '>', Carbon::now())
            ->where('stock_level_at_store', 0)
            ->count();

        $todaySales = Sale::with('user', 'payment_mode')
            ->when(!Auth::user()->is_admin, function ($q) {
                $q->where('user_id', Auth::id());
            })
            ->whereDate('updated_at', Carbon::today())->latest()->get();

        $todaySalesAmountPaid = $todaySales->sum('amount_paid');
        $todaySalesAmountDebt = $todaySales->sum('amount_debt');

        $todaySalesCash = number_format($todaySalesAmountPaid - $todaySalesAmountDebt, 2);

        $salesToday = $todaySales->take(10);

        foreach ($salesToday as $sales) {
            $sales['sold_at'] = Carbon::parse($sales['updated_at'])->format('d/m/Y');
        }

        return Inertia::render((Auth::user()->is_admin ? 'Admin/' : 'Dispensary/') . 'Dashboard', compact(
            'admins',
            'pharmacists',
            'products',
            'expiredProducts',
            'dispensaryShortage',
            'storeShortage',
            'todaySalesCash',
            'salesToday'
        ));
    }
}
