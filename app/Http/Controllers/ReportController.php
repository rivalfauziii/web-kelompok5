<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $branchId = $request->branch_id;
        $reportType = $request->report_type ?? 'sales';

        if ($user->role != 'owner') {
            $branchId = $user->branch_id;
        }

        $transactionQuery = Transaction::with(['user', 'branch']);
        $productQuery = Product::query();
        $stockQuery = StockMovement::with(['product', 'user']);

        if ($branchId) {
            $transactionQuery->where('branch_id', $branchId);
            $productQuery->where('branch_id', $branchId);

            $stockQuery->whereHas('product', function ($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            });
        }

        $totalSales = $transactionQuery->sum('total');
        $totalTransactions = $transactionQuery->count();
        $totalProducts = $productQuery->count();
        $lowStock = $productQuery->where('stock', '<=', 10)->count();

        $avgTransaction = $totalTransactions > 0
            ? $totalSales / $totalTransactions
            : 0;

        $transactions = $transactionQuery
            ->latest()
            ->take(20)
            ->get();

        $stockMovements = $stockQuery
            ->latest()
            ->take(20)
            ->get();

        $branches = Branch::all();

        return view('reports.index', compact(
            'reportType',
            'totalSales',
            'totalTransactions',
            'totalProducts',
            'lowStock',
            'avgTransaction',
            'transactions',
            'stockMovements',
            'branches'
        ));
    }
    public function downloadPdf(Request $request)
    {
        $user = auth()->user();

        $branchId = $request->branch_id;
        $reportType = $request->report_type ?? 'sales';

        if ($user->role == 'warehouse' && $reportType != 'stock') {
            abort(403);
        }

        if ($user->role == 'supervisor' && $reportType == 'stock') {
            abort(403);
        }

        if ($user->role == 'cashier' && $reportType != 'transaction') {
            abort(403);
        }

        if ($user->role != 'owner') {
            $branchId = $user->branch_id;
        }

        $transactionQuery = Transaction::with(['user', 'branch']);
        $productQuery = Product::query();
        $stockQuery = StockMovement::with(['product.branch', 'user']);

        if ($branchId) {
            $transactionQuery->where('branch_id', $branchId);
            $productQuery->where('branch_id', $branchId);

            $stockQuery->whereHas('product', function ($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            });
        }

        $totalSales = $transactionQuery->sum('total');
        $totalTransactions = $transactionQuery->count();
        $totalProducts = $productQuery->count();
        $lowStock = $productQuery->where('stock', '<=', 10)->count();

        $transactions = $transactionQuery->latest()->get();
        $stocks = $stockQuery->latest()->get();

        $branchName = "Semua Cabang";

        if ($branchId) {
            $branch = Branch::find($branchId);
            $branchName = $branch ? $branch->name : "-";
        }

        $pdf = Pdf::loadView('reports.pdf', compact(
            'reportType',
            'branchName',
            'totalSales',
            'totalTransactions',
            'totalProducts',
            'lowStock',
            'transactions',
            'stocks'
        ));

        return $pdf->download('laporan-syakamarket.pdf');
    }
}