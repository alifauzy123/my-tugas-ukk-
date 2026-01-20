<?php

namespace App\Http\Controllers;

use App\Models\PenerimaanBarang;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\MutasiStok;
use App\Models\Produk;
use Illuminate\Http\Request;

class PenerimaanBarangController extends Controller
{
    public function index()
    {
        $data = PenerimaanBarang::latest()->get();
        return view('penerimaan_barang.index', compact('data'));
    }

    public function create()
    {
        $supplier = Supplier::all();
        $po = PurchaseOrder::where('status', 'aktif')->get();

        $last = PenerimaanBarang::orderBy('kode_penerimaan', 'desc')->first();
        $next = $last ? intval(substr($last->kode_penerimaan, 2)) + 1 : 1;
        $kode = 'PB' . str_pad($next, 3, '0', STR_PAD_LEFT);


        return view('penerimaan_barang.create', compact('supplier', 'po', 'kode'));
    }

    /* ====================== AJAX GET PO ====================== */
    public function getDataPO($kode_po)
    {
        $po = PurchaseOrder::where('kode_po', $kode_po)->first();

        if (!$po) {
            return response()->json(['status' => false]);
        }

        $supplier = Supplier::find($po->supplier_id);

        return response()->json([
            'status' => true,
            'data' => [
                'supplier_id'   => $supplier->id,
                'nama_supplier' => $supplier->nama_supplier,
                'produk_id'     => $po->produk_id,
                'nama_produk'   => $po->nama_produk,
                'harga'         => $po->harga_produk,
                'dp'            => $po->dp ?? 0,
                'diskon'        => $po->diskon ?? 0,
                'pajak'         => $po->pajak ?? 0,
                'subtotal'      => $po->subtotal,
                'kode_po'       => $po->kode_po
            ]
        ]);
    }

    /* ====================== STORE ====================== */
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id'  => 'required',
            'kode_po'      => 'required',
            'produk_id'    => 'nullable',
            'jumlah'       => 'required|numeric',
            'harga'        => 'required|numeric',
            'tanggal'      => 'required|date',
        ]);

        $penerimaan = PenerimaanBarang::create([
            'kode_penerimaan' => $request->kode_penerimaan,
            'nama_produk' => $request->nama_produk,
            'supplier_id'     => $request->supplier_id,
            'nama_supplier'   => $request->nama_supplier, 
            'kode_po'         => $request->kode_po,
            'produk_id'       => $request->produk_id,
            'harga'           => $request->harga,
            'jumlah'          => $request->jumlah,
            'tanggal'         => $request->tanggal,
            'dp'              => $request->dp ?? 0,
            'diskon'          => $request->diskon ?? 0,
            'pajak'           => $request->pajak ?? 0,
            'subtotal'        => $request->subtotal,
            'catatan'         => $request->catatan,
            'status'          => 'aktif'
        ]);

        /* ==== UPDATE STOK ==== */
        if ($request->produk_id) {
            $produk = Produk::find($request->produk_id);

            if ($produk) {
                // Simpan stok sebelum perubahan
                $stokSebelum = $produk->stok;

                // Update stok baru
                $produk->stok += $request->jumlah;
                $produk->save();

                $stokSesudah = $produk->stok;

                MutasiStok::create([
                    'produk_id'     => $request->produk_id,
                    'jenis_mutasi'  => 'IN',
                    'qty_mutasi'    => $request->jumlah,
                    'stok_sebelum'  => $stokSebelum,
                    'stok_sesudah'  => $stokSesudah,
                    'keterangan'    => 'Penerimaan barang #' . $penerimaan->kode_penerimaan,
                ]);


            }
        }

        PurchaseOrder::where('kode_po', $request->kode_po)
            ->update(['status' => 'nonaktif']);

        return redirect()->route('penerimaan_barang.index')
            ->with('success', 'Penerimaan barang berhasil disimpan!');
    }

    /* ====================== SHOW ====================== */
    public function show($id)
    {
        $data = PenerimaanBarang::findOrFail($id);
        return view('penerimaan_barang.show', compact('data'));
    }

    /* ====================== EDIT ====================== */
    public function edit($id)
    {
        $data = PenerimaanBarang::findOrFail($id);
        $supplier = Supplier::all();
        $po = PurchaseOrder::all();

        return view('penerimaan_barang.edit', compact('data', 'supplier', 'po'));
    }

    /* ====================== UPDATE (AMANKAN STOK) ====================== */
public function update(Request $request, $id)
{
    $request->validate([
        'supplier_id'  => 'required',
        'produk_id'    => 'nullable',
        'harga'        => 'required|numeric',
        'jumlah'       => 'required|numeric',
        'tanggal'      => 'required|date',
    ]);

    $data = PenerimaanBarang::findOrFail($id);

    $jumlahLama = $data->jumlah;          // jumlah lama dari DB
    $jumlahBaru = $request->jumlah;       // jumlah input baru
    $produkLamaId = $data->produk_id;
    $produkBaruId = $request->produk_id;

    // Hitung selisih
    $selisih = $jumlahBaru - $jumlahLama;

    /* ========================================================
        1. KEMBALIKAN PERUBAHAN STOK (MUTASI)
       ======================================================== */

    if ($produkLamaId) {

        $produkLama = Produk::find($produkLamaId);

        if ($produkLama) {
            // Jika jumlah berubah, lakukan mutasi
            if ($selisih != 0) {

                $stokSebelum = $produkLama->stok;

                // Jika selisih > 0 → IN (stok bertambah)
                // Jika selisih < 0 → OUT (stok berkurang)
                $produkLama->stok += $selisih;
                $produkLama->save();

                MutasiStok::create([
                    'produk_id'     => $produkLama->id,
                    'jenis_mutasi'  => $selisih > 0 ? 'IN' : 'OUT',
                    'qty_mutasi'    => abs($selisih),
                    'stok_sebelum'  => $stokSebelum,
                    'stok_sesudah'  => $produkLama->stok,
                    'keterangan'    => 'Revisi penerimaan #' . $data->kode_penerimaan,
                    'tanggal'       => $request->tanggal,
                ]);
            }
        }
    }

    /* ========================================================
        2. UPDATE DATA PENERIMAAN
       ======================================================== */
    $data->update([
        'supplier_id' => $request->supplier_id,
        'nama_produk' => $request->nama_produk,
        'produk_id'   => $produkBaruId,
        'harga'       => $request->harga,
        'jumlah'      => $jumlahBaru,
        'tanggal'     => $request->tanggal,
        'dp'          => $request->dp ?? 0,
        'diskon'      => $request->diskon ?? 0,
        'pajak'       => $request->pajak ?? 0,
        'subtotal'    => $request->subtotal,
        'catatan'     => $request->catatan,
    ]);

    return redirect()->route('penerimaan_barang.index')
        ->with('success', 'Data berhasil diupdate!');
}



    /* ====================== DELETE (KEMBALIKAN STOK) ====================== */
    public function destroy($id)
    {
        $p = PenerimaanBarang::findOrFail($id);

        if ($p->produk_id) {
            $produk = Produk::find($p->produk_id);

            if ($produk) {
                $produk->stok -= $p->jumlah;
                $produk->save();
            }
        }

        $p->delete();

        return redirect()->route('penerimaan_barang.index')
            ->with('success', 'Data berhasil dihapus.');
    }
}
