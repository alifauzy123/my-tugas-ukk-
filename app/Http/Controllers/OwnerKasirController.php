<?php

namespace App\Http\Controllers;

use App\Models\Kasir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OwnerKasirController extends Controller
{
    public function index()
    {
        $kasir = Kasir::orderBy('id')->get();
        return view('owner.kasir.index', compact('kasir'));
    }

    public function show($id)
    {
        $kasir = Kasir::findOrFail($id);
        return view('owner.kasir.show', compact('kasir'));
    }

    public function edit($id)
    {
        $kasir = Kasir::findOrFail($id);
        return view('owner.kasir.edit', compact('kasir'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'password' => 'nullable|min:6',
        ]);

        $kasir = Kasir::findOrFail($id);
        $kasir->status = $request->status;

        if ($request->filled('password')) {
            $kasir->password = Hash::make($request->password);
        }

        $kasir->save();

        return redirect()->route('owner.kasir.index')->with('success', 'Status kasir berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kasir = Kasir::findOrFail($id);
        $kasir->delete();

        return redirect()->route('owner.kasir.index')->with('success', 'Data berhasil dihapus.');
    }
}
