<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $stocks = StockMovement::latest()
            ->paginate(10);

        return view(
            'stocks.index',
            compact('stocks')
        );
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

        if($request->type == 'in'){

            $product->increment(
                'stock',
                $request->qty
            );

        } else {

            $product->decrement(
                'stock',
                $request->qty
            );
        }

        StockMovement::create([
            'product_id' => $request->product_id,
            'type' => $request->type,
            'qty' => $request->qty,
            'description' => $request->description,
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('stocks.index')
            ->with(
                'success',
                'Stock berhasil diperbarui'
            );
    }
}