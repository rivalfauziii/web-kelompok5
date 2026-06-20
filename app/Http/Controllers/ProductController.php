<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('branch');

        if (auth()->user()->role != 'owner') {
            $query->where('branch_id', auth()->user()->branch_id);
        }

        if ($request->branch_id) {
            $query->where('branch_id', $request->branch_id);
        }

        $products = $query->latest()->paginate(10);
        $branches = Branch::all();

        return view('products.index', compact('products', 'branches'));
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
            'branch_id' => $request->branch_id,
            'name' => $request->name,
            'barcode' => $request->barcode,
            'price' => $request->price,
            'stock' => $request->stock,
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
            'branch_id' => $request->branch_id,
            'name' => $request->name,
            'barcode' => $request->barcode,
            'price' => $request->price,
            'stock' => $request->stock,
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