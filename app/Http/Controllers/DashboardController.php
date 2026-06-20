<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $productQuery = Product::query();
        $transactionQuery = Transaction::query();

        if ($user->role !== 'owner') {
            $productQuery->where('branch_id', $user->branch_id);
            $transactionQuery->where('branch_id', $user->branch_id);
        }

        /*
        |--------------------------------------------------------------------------
        | STATS
        |--------------------------------------------------------------------------
        */

        $totalProducts = (clone $productQuery)->count();

        $totalTransactions = (clone $transactionQuery)->count();

        $totalSales = (clone $transactionQuery)->sum('total');

        $lowStocks = (clone $productQuery)
            ->where('stock', '<=', 5)
            ->count();

        $todaySales = (clone $transactionQuery)
            ->whereDate('created_at', today())
            ->sum('total');

        /*
        |--------------------------------------------------------------------------
        | BEST PRODUCTS
        |--------------------------------------------------------------------------
        */

        $bestProducts = TransactionDetail::selectRaw(
            'product_id, SUM(qty) as total_qty'
        )
            ->groupBy('product_id')
            ->with('product')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | SALES CHART
        |--------------------------------------------------------------------------
        */

        $salesChart = $transactionQuery
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as total')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->take(7)
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalTransactions',
            'totalSales',
            'lowStocks',
            'todaySales',
            'bestProducts',
            'salesChart'
        ));
    }
}