<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CashierController extends Controller
{
    public function index()
    {
        $products = Product::all();

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

                $product = Product::find($item['id']);

                $product->decrement('stock', $item['qty']);
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
    public function history()
    {
        $transactions = Transaction::latest()->paginate(10);

        return view(
            'cashier.history',
            compact('transactions')
        );
    }
    public function show($id)
    {
        $transaction = Transaction::with('details.product')
            ->findOrFail($id);

        return view(
            'cashier.show',
            compact('transaction')
        );
    }
}