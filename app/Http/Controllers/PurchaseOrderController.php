<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\KategoriProduk;
use App\Models\Supplier;
use App\Models\Produk;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    private function generateKodePO()
    {
        $lastPO = PurchaseOrder::orderBy('id', 'desc')->first();

        if (!$lastPO) {
            return 'PO001';
        }

        $num = intval(substr($lastPO->kode_po, 2)) + 1;
        return 'PO' . str_pad($num, 3, '0', STR_PAD_LEFT);
    }

    public function index()
    {
        $data = PurchaseOrder::with(['kategori','supplier'])->paginate(10);
        return view('purchase_order.index', compact('data'));
    }

    public function create()
    {
        $kategori = KategoriProduk::all();
        $supplier = Supplier::all();
        $produk   = Produk::all();  // ← tambahan
        $kode_po = $this->generateKodePO();

        return view('purchase_order.create', compact('kategori', 'supplier', 'produk', 'kode_po'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_produk_id' => 'required',
            'supplier_id'        => 'required',
            'produk_id'          =>'nullable|exists:produks,id',// ← tambahan
            'nama_produk'        => 'required',
            'harga_produk'       => 'required|numeric',
            'tanggal'            => 'required|date',
            'jumlah'             => 'required|integer',
            'diskon'             => 'nullable|numeric',
            'pajak'              => 'nullable|numeric',
            'dp'                 => 'nullable|numeric',
            'catatan'            => 'nullable',
            'status'             => 'required|in:aktif,nonaktif',
        ]);

        // ======== PERHITUNGAN =========
        $harga_produk = $validated['harga_produk'];
        $jumlah       = $validated['jumlah'];

        $diskon = $validated['diskon'] ?? 0;
        $pajak  = $validated['pajak'] ?? 0;
        $dp     = $validated['dp'] ?? 0;

        $grand_total = $harga_produk * $jumlah;
        $subtotal = ($grand_total - $dp - $diskon) + $pajak;

        PurchaseOrder::create([
            'kode_po'            => $this->generateKodePO(),
            'kategori_produk_id' => $validated['kategori_produk_id'],
            'supplier_id'        => $validated['supplier_id'],
            'produk_id'          => $validated['produk_id'],   // ← tambahan
            'nama_produk'        => $validated['nama_produk'],
            'harga_produk'       => $harga_produk,
            'tanggal'            => $validated['tanggal'],
            'jumlah'             => $jumlah,
            'diskon'             => $diskon,
            'pajak'              => $pajak,
            'dp'                 => $dp,
            'subtotal'           => $subtotal,
            'grand_total'        => $grand_total,
            'catatan'            => $validated['catatan'],
            'status'             => $validated['status'],
        ]);

        return redirect()->route('purchase_order.index')
                         ->with('success', 'Purchase Order berhasil ditambahkan!');
    }

    public function show($id)
    {
        $po = PurchaseOrder::with(['kategori','supplier'])->findOrFail($id);
        return view('purchase_order.show', compact('po'));
    }

    public function edit($id)
    {
        $po = PurchaseOrder::findOrFail($id);
        $kategori = KategoriProduk::all();
        $supplier = Supplier::all();
        $produk   = Produk::all(); // ← tambahan

        return view('purchase_order.edit', compact('po', 'kategori', 'supplier', 'produk'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kategori_produk_id' => 'required',
            'supplier_id'        => 'required',
            'produk_id'          => 'nullable|exists:produk,id',  // ← tambahan
            'nama_produk'        => 'required',
            'harga_produk'       => 'required|numeric',
            'tanggal'            => 'required|date',
            'jumlah'             => 'required|integer',
            'diskon'             => 'nullable|numeric',
            'pajak'              => 'nullable|numeric',
            'dp'                 => 'nullable|numeric',
            'catatan'            => 'nullable',
            'status'             => 'required|in:aktif,nonaktif',
        ]);

        // ======== PERHITUNGAN ULANG =========
        $harga_produk = $validated['harga_produk'];
        $jumlah       = $validated['jumlah'];

        $diskon = $validated['diskon'] ?? 0;
        $pajak  = $validated['pajak'] ?? 0;
        $dp     = $validated['dp'] ?? 0;

        $grand_total = $harga_produk * $jumlah;
        $subtotal = ($grand_total - $dp - $diskon) + $pajak;

        PurchaseOrder::where('id', $id)->update([
            'kategori_produk_id' => $validated['kategori_produk_id'],
            'supplier_id'        => $validated['supplier_id'],
            'produk_id'          => $validated['produk_id'],   // ← tambahan
            'nama_produk'        => $validated['nama_produk'],
            'harga_produk'       => $harga_produk,
            'tanggal'            => $validated['tanggal'],
            'jumlah'             => $jumlah,
            'diskon'             => $diskon,
            'pajak'              => $pajak,
            'dp'                 => $dp,
            'subtotal'           => $subtotal,
            'grand_total'        => $grand_total,
            'catatan'            => $validated['catatan'],
            'status'             => $validated['status'],
        ]);

        return redirect()->route('purchase_order.index')
                         ->with('success', 'Purchase Order berhasil diperbarui!');
    }

    public function destroy($id)
    {
        PurchaseOrder::destroy($id);

        return redirect()->route('purchase_order.index')
                         ->with('success', 'Purchase Order berhasil dihapus!');
    }
}
