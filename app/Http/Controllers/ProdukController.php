<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\MutasiStok;
use App\Models\RiwayatHarga;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::with('kategori')->orderBy('id')->get();
        return view('produk.index', compact('produk'));
    }

    public function create()
    {
        $kategori = KategoriProduk::all();
        return view('produk.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk'   => 'required|string|max:100',
            'harga'         => 'required|numeric|min:0',
            'stok'          => 'required|numeric|min:0',
            'kategori_id'   => 'required|exists:kategori_produk,id',
            'status'        => 'required|in:Aktif,Nonaktif',
            'gambar'        => 'nullable|image|max:2048', // max 2MB
        ]);

        $last = Produk::latest()->first();
        $kode = 'PRD' . str_pad(($last?->id + 1 ?? 1), 3, '0', STR_PAD_LEFT);

        $path = null;
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('produk', 'public');
        }

        Produk::create([
            'kode_produk'   => $kode,
            'nama_produk'   => $request->nama_produk,
            'harga'         => $request->harga,
            'stok'          => $request->stok,
            'kategori_id'   => $request->kategori_id,
            'status'        => $request->status,
            'gambar'        => $path,
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show($id)
    {
        $produk = Produk::with('kategori')->findOrFail($id);
        return view('produk.show', compact('produk'));
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kategori = KategoriProduk::all();
        return view('produk.edit', compact('produk', 'kategori'));
    }

public function update(Request $request, $id)
{
    $request->validate([
        'nama_produk' => 'required|string|max:100',
        'harga' => 'required|numeric|min:0',
        'stok' => 'required|numeric|min:0',
        'kategori_id' => 'required|exists:kategori_produk,id',
        'status' => 'required|in:Aktif,Nonaktif',
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $produk = Produk::findOrFail($id);

    // SIMPAN STOK LAMA SEBELUM UPDATE
    $stokLama = $produk->stok;
    $stokBaru = $request->stok;

    $data = [
        'nama_produk' => $request->nama_produk,
        'harga' => $request->harga,
        'stok' => $stokBaru,
        'kategori_id' => $request->kategori_id,
        'status' => $request->status,
    ];

    if ($request->hasFile('gambar')) {
        if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $data['gambar'] = $request->file('gambar')->store('produk', 'public');
    }

    // UPDATE PRODUK
    $produk->update($data);

    // ==== TAMBAHKAN MUTASI STOK (ADJUST) ====
    // ==== TAMBAHKAN MUTASI STOK (ADJUST) ====
if ($stokBaru != $stokLama) {
    $selisih = $stokBaru - $stokLama; // bisa positif atau negatif
    $qtyMutasi = abs($selisih);      // tetap positif

    MutasiStok::create([
        'produk_id'     => $produk->id,
        'jenis_mutasi'  => 'ADJUST',
        'qty_mutasi'    => $qtyMutasi,     // <--- Tidak ada minus lagi
        'stok_sebelum'  => $stokLama,
        'stok_sesudah'  => $stokBaru,
        'keterangan'    => $selisih > 0 
                            ? 'Penyesuaian stok (bertambah)' 
                            : 'Penyesuaian stok (berkurang)',
    ]);
}


    return redirect()->route('produk.index')
        ->with('success', 'Produk berhasil diperbarui.');
}



    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        // Hapus gambar dari storage
        if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function editHarga(Request $request, $id)
{
    $request->validate([
        'harga_baru' => 'required|numeric|min:0'
    ]);

    $produk = Produk::findOrFail($id);

    // Simpan riwayat harga
    \DB::table('riwayat_harga')->insert([
        'produk_id' => $produk->id,
        'harga_lama' => $produk->harga,
        'harga_baru' => $request->harga_baru,
        'created_at' => now(),
        'updated_at' => now()
    ]);

    // Update harga
    $produk->update([
        'harga' => $request->harga_baru
    ]);

    return response()->json(['success' => true]);
}

public function historyHarga($id)
{
    $data = \DB::table('riwayat_harga')
        ->where('produk_id', $id)
        ->orderByDesc('created_at')
        ->get();

    return response()->json($data);
}

public function historyStok($id)
{
    $data = MutasiStok::where('produk_id', $id)
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json($data);
}



}
