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
        $totalProducts = Product::count();

        $totalTransactions = Transaction::count();

        $totalSales = Transaction::sum('total');

        $lowStocks = Product::where('stock', '<=', 5)
            ->count();

        $todaySales = Transaction::whereDate(
            'created_at',
            today()
        )->sum('total');

        $bestProducts = TransactionDetail::selectRaw(
            'product_id, SUM(qty) as total_qty'
        )
            ->groupBy('product_id')
            ->with('product')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();
        $salesChart = Transaction::select(
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