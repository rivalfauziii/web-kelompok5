<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        if (auth()->user()->role == 'owner') {

            $products = Product::latest()->paginate(10);

        } else {

            $products = Product::where(
                'branch_id',
                auth()->user()->branch_id
            )->latest()->paginate(10);

        }

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'stock' => 'required',
            'price' => 'required',
        ]);

        $image = null;

        if ($request->hasFile('image')) {

            $image = $request->file('image')
                ->store('products', 'public');
        }

        Product::create([
            'branch_id' => auth()->user()->branch_id,
            'name' => $request->name,
            'barcode' => $request->barcode,
            'stock' => $request->stock,
            'price' => $request->price,
            'image' => $image
        ]);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit(Product $product)
    {
        if (
            auth()->user()->role != 'owner' &&
            $product->branch_id != auth()->user()->branch_id
        ) {
            abort(403);
        }

        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        if (
            auth()->user()->role != 'owner' &&
            $product->branch_id != auth()->user()->branch_id
        ) {
            abort(403);
        }

        $image = $product->image;

        if ($request->hasFile('image')) {

            $image = $request->file('image')
                ->store('products', 'public');
        }

        $product->update([
            'name' => $request->name,
            'barcode' => $request->barcode,
            'stock' => $request->stock,
            'price' => $request->price,
            'image' => $image
        ]);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil diupdate');
    }

    public function destroy(Product $product)
    {
        if (
            auth()->user()->role != 'owner' &&
            $product->branch_id != auth()->user()->branch_id
        ) {
            abort(403);
        }

        $product->delete();

        return back()
            ->with('success', 'Produk berhasil dihapus');
    }
}