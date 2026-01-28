<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\KasirLoginLog;
use Illuminate\Support\Facades\Response;
class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $today = Carbon::today();

        // Data grafik pesanan 7 hari terakhir
        $pesananChart = Pesanan::selectRaw('DATE(created_at) as tanggal, COUNT(*) as jumlah')
            ->where('created_at', '>=', now()->subDays(6))
            ->groupByRaw('DATE(created_at)')
            ->orderByRaw('DATE(created_at)')
            ->get();

        // Data tambahan
        $totalProduk = Produk::count();
        $totalStok   = Produk::sum('stok');
        $pesananHariIni = Pesanan::whereDate('created_at', $today)->count();

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $kasirLogsQuery = KasirLoginLog::with('kasir')->orderByDesc('logged_at');

        if ($startDate) {
            $start = Carbon::parse($startDate, 'Asia/Jakarta')->startOfDay();
            $end = $endDate
                ? Carbon::parse($endDate, 'Asia/Jakarta')->endOfDay()
                : Carbon::parse($startDate, 'Asia/Jakarta')->endOfDay();

            $kasirLogsQuery->whereBetween('logged_at', [$start, $end]);
        } else {
            $kasirLogsQuery->limit(10);
        }

        $kasirLogs = $kasirLogsQuery->get();

        return view('dashboard', compact(
            'pesananChart',
            'totalProduk',
            'totalStok',
            'pesananHariIni',
            'kasirLogs',
            'startDate',
            'endDate'
        ));
    }

    public function exportKasirAktivitas(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if ($startDate) {
            $start = Carbon::parse($startDate, 'Asia/Jakarta')->startOfDay();
            $end = $endDate
                ? Carbon::parse($endDate, 'Asia/Jakarta')->endOfDay()
                : Carbon::parse($startDate, 'Asia/Jakarta')->endOfDay();
        } else {
            $start = Carbon::now('Asia/Jakarta')->startOfDay();
            $end = Carbon::now('Asia/Jakarta')->endOfDay();
        }

        $kasirLogs = KasirLoginLog::with('kasir')
            ->whereBetween('logged_at', [$start, $end])
            ->orderByDesc('logged_at')
            ->get();

        $filename = 'aktivitas_kasir_' . $start->format('Ymd') . '_' . $end->format('Ymd') . '.csv';

        $callback = function () use ($kasirLogs) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Kasir', 'Username', 'Aksi', 'Waktu']);

            foreach ($kasirLogs as $log) {
                fputcsv($handle, [
                    $log->kasir->nama_lengkap ?? '-',
                    $log->kasir->username ?? '-',
                    $log->action,
                    $log->logged_at?->timezone('Asia/Jakarta')->format('d/m/Y H:i:s') ?? '-'
                ]);
            }

            fclose($handle);
        };

        return Response::streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
