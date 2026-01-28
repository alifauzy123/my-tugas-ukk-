<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KasirTransaksiController extends Controller
{
    public function index()
    {
        $menus = Menu::whereIn('status', ['aktif', 'Aktif'])
            ->orderBy('nama_menu')
            ->get();

        return view('kasir.transaksi', compact('menus'));
    }

    public function list()
    {
        $kasir = Auth::guard('kasir')->user();
        $todayStart = Carbon::now('Asia/Jakarta')->startOfDay();
        $todayEnd = Carbon::now('Asia/Jakarta')->endOfDay();

        $transaksis = Transaksi::with(['kasir', 'items.menu'])
            ->where('kasir_id', $kasir->id)
            ->whereBetween('tanggal', [$todayStart, $todayEnd])
            ->orderByDesc('tanggal')
            ->get();

        return view('kasir.daftar_transaksi', compact('transaksis'));
    }

    public function ownerList(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Transaksi::with(['kasir', 'items.menu']);

        if ($startDate) {
            $start = Carbon::parse($startDate, 'Asia/Jakarta')->startOfDay();
            $end = $endDate
                ? Carbon::parse($endDate, 'Asia/Jakarta')->endOfDay()
                : Carbon::parse($startDate, 'Asia/Jakarta')->endOfDay();
            $query->whereBetween('tanggal', [$start, $end]);
        }

        $transaksis = $query->orderByDesc('tanggal')->get();

        return view('owner.daftar_transaksi', compact('transaksis', 'startDate', 'endDate'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer|exists:menus,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.type' => 'required|in:Dine In,Take Away',
            'paid' => 'required|numeric|min:0',
        ]);

        $kasirId = Auth::guard('kasir')->id();

        $menuIds = collect($request->items)->pluck('id')->unique();
        $menus = Menu::whereIn('id', $menuIds)->get()->keyBy('id');

        $total = 0;
        foreach ($request->items as $item) {
            $menu = $menus->get($item['id']);
            if (!$menu) {
                return response()->json(['message' => 'Menu tidak ditemukan.'], 422);
            }
            $total += $menu->harga * (int) $item['qty'];
        }

        $paid = (float) $request->paid;
        if ($paid < $total) {
            return response()->json(['message' => 'Uang dibayar kurang.'], 422);
        }

        $kembalian = $paid - $total;

        $transaksi = DB::transaction(function () use ($kasirId, $total, $paid, $kembalian, $menus, $request) {
            $latest = Transaksi::latest('id')->first();
            $nextId = $latest ? $latest->id + 1 : 1;
            $kode = 'TRX' . str_pad($nextId, 6, '0', STR_PAD_LEFT);

            $trx = Transaksi::create([
                'kode_transaksi' => $kode,
                'kasir_id' => $kasirId,
                'total' => $total,
                'uang_dibayar' => $paid,
                'kembalian' => $kembalian,
                'tanggal' => Carbon::now('Asia/Jakarta'),
                'status' => 'Dibayar',
            ]);

            foreach ($request->items as $item) {
                $menu = $menus->get($item['id']);
                $qty = (int) $item['qty'];
                $subtotal = $menu->harga * $qty;

                TransaksiItem::create([
                    'transaksi_id' => $trx->id,
                    'menu_id' => $menu->id,
                    'qty' => $qty,
                    'harga_satuan' => $menu->harga,
                    'subtotal' => $subtotal,
                    'tipe_pesanan' => $item['type'],
                ]);
            }

            return $trx;
        });

        $kasir = Auth::guard('kasir')->user();
        $items = collect($request->items)->map(function ($item) use ($menus) {
            $menu = $menus->get($item['id']);
            $qty = (int) $item['qty'];
            $harga = $menu?->harga ?? 0;
            return [
                'nama' => $menu?->nama_menu ?? '-',
                'qty' => $qty,
                'harga' => $harga,
                'subtotal' => $harga * $qty,
                'tipe' => $item['type'],
            ];
        })->values();

        return response()->json([
            'message' => 'Transaksi berhasil disimpan.',
            'kode' => $transaksi->kode_transaksi,
            'receipt' => [
                'kode' => $transaksi->kode_transaksi,
                'tanggal' => Carbon::now('Asia/Jakarta')->format('d/m/Y H:i'),
                'kasir' => $kasir->nama_lengkap ?? 'Kasir',
                'items' => $items,
                'total' => $total,
                'dibayar' => $paid,
                'kembalian' => $kembalian,
            ],
            'kitchen_receipt' => [
                'kode' => $transaksi->kode_transaksi,
                'tanggal' => Carbon::now('Asia/Jakarta')->format('d/m/Y H:i'),
                'kasir' => $kasir->nama_lengkap ?? 'Kasir',
                'items' => $items,
            ],
        ]);
    }
}
