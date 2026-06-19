<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::latest()->get();

        return view('branches.index', compact('branches'));
    }

    public function create()
    {
        return view('branches.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'city' => 'required',
            'address' => 'required',
        ]);

        Branch::create([
            'name' => $request->name,
            'city' => $request->city,
            'address' => $request->address,
        ]);

        return redirect()
            ->route('branches.index')
            ->with('success', 'Cabang berhasil ditambahkan');
    }

    public function edit(Branch $branch)
    {
        return view('branches.edit', compact('branch'));
    }

    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'name' => 'required',
            'city' => 'required',
            'address' => 'required',
        ]);

        $branch->update([
            'name' => $request->name,
            'city' => $request->city,
            'address' => $request->address,
        ]);

        return redirect()
            ->route('branches.index')
            ->with('success', 'Cabang berhasil diupdate');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();

        return redirect()
            ->route('branches.index')
            ->with('success', 'Cabang berhasil dihapus');
    }
}