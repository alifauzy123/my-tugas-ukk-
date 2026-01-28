<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\KategoriProduk;
use App\Models\MenuRiwayatHarga;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::with('kategori')->get();
        return view('menu.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = KategoriProduk::where('status', 'Aktif')->get();
        return view('menu.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_menu' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'kategori_id' => 'required|exists:kategori_produk,id',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('menus', 'public');
            $validated['gambar'] = $path;
        }

        Menu::create($validated);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        return view('menu.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        $kategoris = KategoriProduk::where('status', 'Aktif')->get();
        return view('menu.edit', compact('menu', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'nama_menu' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'kategori_id' => 'required|exists:kategori_produk,id',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('menus', 'public');
            $validated['gambar'] = $path;
        }

        if ((float) $validated['harga'] != (float) $menu->harga) {
            MenuRiwayatHarga::create([
                'menu_id' => $menu->id,
                'harga_lama' => (int) $menu->harga,
                'harga_baru' => (int) $validated['harga'],
            ]);
        }

        $menu->update($validated);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus');
    }

    public function editHarga(Request $request, $id)
    {
        $request->validate([
            'harga_baru' => 'required|numeric|min:0'
        ]);

        $menu = Menu::findOrFail($id);

        if ((float) $request->harga_baru != (float) $menu->harga) {
            MenuRiwayatHarga::create([
                'menu_id' => $menu->id,
                'harga_lama' => (int) $menu->harga,
                'harga_baru' => (int) $request->harga_baru,
            ]);

            $menu->update([
                'harga' => $request->harga_baru
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function historyHarga($id)
    {
        $history = MenuRiwayatHarga::where('menu_id', $id)
            ->orderByDesc('created_at')
            ->get();

        return response()->json($history);
    }
}
