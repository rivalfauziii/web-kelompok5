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
            'address' => 'required',
            'city' => 'required',
        ]);

        Branch::create([
            'name' => $request->name,
            'address' => $request->address,
            'city' => $request->city,
        ]);

        return redirect()
            ->route('branches.index')
            ->with('success', 'Cabang berhasil ditambahkan');
    }
}