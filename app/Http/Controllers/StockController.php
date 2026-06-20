<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class StockController extends Controller
{

    public function index(Request $request)
    {
        $query = Product::with('branch');

        if (auth()->user()->role != 'owner') {

            $query->where(
                'branch_id',
                auth()->user()->branch_id
            );

        } elseif ($request->branch_id) {

            $query->where(
                'branch_id',
                $request->branch_id
            );
        }

        $products = $query->get();

        $stocksQuery = StockMovement::with([
            'product.branch',
            'user'
        ]);

        if (auth()->user()->role != 'owner') {

            $stocksQuery->whereHas(
                'product',
                function ($q) {

                    $q->where(
                        'branch_id',
                        auth()->user()->branch_id
                    );

                }
            );

        } else {

            if ($request->branch_id) {

                $stocksQuery->whereHas(
                    'product',
                    function ($q) use ($request) {

                        $q->where(
                            'branch_id',
                            $request->branch_id
                        );

                    }
                );

            }

        }

        $stocks = $stocksQuery
            ->latest()
            ->paginate(20);

        $branches = \App\Models\Branch::all();

        return view('stocks.index', compact(
            'products',
            'stocks',
            'branches'
        ));
    }

    public function create()
    {
        $products = Product::all();

        return view(
            'stocks.create',
            compact('products')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'type' => 'required',
            'qty' => 'required|numeric|min:1',
        ]);

        $product = Product::findOrFail(
            $request->product_id
        );

        if ($request->type == 'in') {

            $product->increment(
                'stock',
                $request->qty
            );

        }
        ;
        if (
            $request->type == 'out'
            &&
            $product->stock < $request->qty
        ) {
            return back()->with(
                'error',
                'Stock tidak mencukupi'
            );
        } else {

            $product->decrement(
                'stock',
                $request->qty
            );
        }

        StockMovement::create([
            'product_id' => $request->product_id,
            'user_id' => auth()->id(),
            'type' => $request->type,
            'qty' => $request->qty,
            'description' => $request->type == 'in'
                ? 'Stock Masuk Gudang'
                : 'Stock Keluar Gudang',
        ]);

        return redirect()
            ->route('stocks.index')
            ->with(
                'success',
                'Stock berhasil diperbarui'
            );
    }
}