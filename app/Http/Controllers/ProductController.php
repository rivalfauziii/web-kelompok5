<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);

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
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
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
        $product->delete();

        return back()
            ->with('success', 'Produk berhasil dihapus');
    }
}