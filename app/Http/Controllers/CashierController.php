<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CashierController extends Controller
{
    public function index()
    {
        if (auth()->user()->role == 'owner') {

            $products = Product::all();

        } else {

            $products = Product::where(
                'branch_id',
                auth()->user()->branch_id
            )->get();
        }

        return view('cashier.index', compact('products'));
    }

    public function checkout(Request $request)
    {
        DB::beginTransaction();

        try {

            $total = 0;

            foreach ($request->products as $item) {

                $total += $item['price'] * $item['qty'];
            }

            $transaction = Transaction::create([

                'user_id' => auth()->id(),

                'branch_id' => auth()->user()->branch_id,

                'invoice' => 'INV-' . time(),

                'total' => $total,

            ]);
            foreach ($request->products as $item) {

                $subtotal = $item['price'] * $item['qty'];

                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['id'],
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                    'subtotal' => $subtotal,
                ]);

                $product = Product::findOrFail($item['id']);

                if ($product->stock < $item['qty']) {

                    throw new \Exception(
                        'Stock ' . $product->name . ' tidak mencukupi'
                    );
                }

                $product->decrement('stock', $item['qty']);

                StockMovement::create([

                    'product_id' => $product->id,

                    'user_id' => auth()->id(),

                    'type' => 'out',

                    'qty' => $item['qty'],

                    'notes' => 'Penjualan Invoice ' . $transaction->invoice,

                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function history(Request $request)
    {
        if (auth()->user()->role == 'owner') {

            $transactions = Transaction::with('branch');

            if ($request->branch_id) {

                $transactions->where(
                    'branch_id',
                    $request->branch_id
                );
            }

            $transactions = $transactions
                ->latest()
                ->paginate(10);

            $branches = \App\Models\Branch::all();

        } else {

            $transactions = Transaction::with('branch')
                ->where(
                    'branch_id',
                    auth()->user()->branch_id
                )
                ->latest()
                ->paginate(10);

            $branches = collect();
        }

        return view(
            'cashier.history',
            compact(
                'transactions',
                'branches'
            )
        );
    }
    public function show($id)
    {
        $transaction = Transaction::with(
            'details.product'
        )->findOrFail($id);

        if (
            auth()->user()->role != 'owner'
            &&
            $transaction->branch_id != auth()->user()->branch_id
        ) {
            abort(403);
        }

        return view(
            'cashier.show',
            compact('transaction')
        );
    }
}