<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Kasir;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class LaporanKasirController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $kasirId = $request->input('kasir_id');

        if ($startDate) {
            $start = Carbon::parse($startDate, 'Asia/Jakarta')->startOfDay();
            $end = $endDate
                ? Carbon::parse($endDate, 'Asia/Jakarta')->endOfDay()
                : Carbon::parse($startDate, 'Asia/Jakarta')->endOfDay();
        } else {
            $start = Carbon::now('Asia/Jakarta')->startOfDay();
            $end = Carbon::now('Asia/Jakarta')->endOfDay();
            $startDate = $start->toDateString();
            $endDate = $end->toDateString();
        }

        $transaksisQuery = Transaksi::with(['kasir', 'items.menu'])
            ->whereBetween('tanggal', [$start, $end]);

        if ($kasirId && $kasirId !== 'all') {
            $transaksisQuery->where('kasir_id', $kasirId);
        }

        $transaksis = $transaksisQuery->orderByDesc('tanggal')->get();

        $summary = $transaksis
            ->groupBy('kasir_id')
            ->map(function ($rows) {
                $kasir = $rows->first()->kasir;
                return [
                    'kasir' => $kasir,
                    'jumlah' => $rows->count(),
                    'omset' => $rows->sum('total'),
                ];
            })
            ->values();

        $kasirs = Kasir::orderBy('nama_lengkap')->get();

        return view('laporan.kasir', compact('transaksis', 'summary', 'startDate', 'endDate', 'kasirs', 'kasirId'));
    }

    public function export(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $kasirId = $request->input('kasir_id');

        if ($startDate) {
            $start = Carbon::parse($startDate, 'Asia/Jakarta')->startOfDay();
            $end = $endDate
                ? Carbon::parse($endDate, 'Asia/Jakarta')->endOfDay()
                : Carbon::parse($startDate, 'Asia/Jakarta')->endOfDay();
        } else {
            $start = Carbon::now('Asia/Jakarta')->startOfDay();
            $end = Carbon::now('Asia/Jakarta')->endOfDay();
        }

        $transaksisQuery = Transaksi::with(['kasir', 'items.menu'])
            ->whereBetween('tanggal', [$start, $end]);

        if ($kasirId && $kasirId !== 'all') {
            $transaksisQuery->where('kasir_id', $kasirId);
        }

        $transaksis = $transaksisQuery->orderByDesc('tanggal')->get();

        $filename = 'laporan_kasir_' . $start->format('Ymd') . '_' . $end->format('Ymd') . '.csv';

        $callback = function () use ($transaksis) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Kode', 'Kasir', 'Tanggal', 'Total', 'Dibayar', 'Kembalian', 'Status', 'Items']);

            $grandTotal = 0;
            $grandQty = 0;

            foreach ($transaksis as $trx) {
                $items = $trx->items->map(function ($item) use (&$grandQty) {
                    $nama = $item->menu->nama_menu ?? '-';
                    $grandQty += $item->qty;
                    return $nama . ' x' . $item->qty . ' (' . $item->tipe_pesanan . ')';
                })->implode('; ');

                $grandTotal += $trx->total;

                fputcsv($handle, [
                    $trx->kode_transaksi,
                    $trx->kasir->nama_lengkap ?? '-',
                    $trx->tanggal?->timezone('Asia/Jakarta')->format('d/m/Y H:i'),
                    $trx->total,
                    $trx->uang_dibayar,
                    $trx->kembalian,
                    $trx->status,
                    $items,
                ]);
            }

            fputcsv($handle, []);
            fputcsv($handle, ['TOTAL', '', '', $grandTotal, '', '', '', 'Jumlah Item: ' . $grandQty]);

            fclose($handle);
        };

        return Response::streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
