<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Menu;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OwnerDashboardController extends Controller
{
    public function index(Request $request)
    {
        $todayStart = Carbon::now('Asia/Jakarta')->startOfDay();
        $todayEnd = Carbon::now('Asia/Jakarta')->endOfDay();

        $weekStart = Carbon::now('Asia/Jakarta')->subDays(6)->startOfDay();
        $weekEnd = Carbon::now('Asia/Jakarta')->endOfDay();
        $prevWeekStart = Carbon::now('Asia/Jakarta')->subDays(13)->startOfDay();
        $prevWeekEnd = Carbon::now('Asia/Jakarta')->subDays(7)->endOfDay();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if ($startDate) {
            $start = Carbon::parse($startDate, 'Asia/Jakarta')->startOfDay();
            $end = $endDate
                ? Carbon::parse($endDate, 'Asia/Jakarta')->endOfDay()
                : Carbon::parse($startDate, 'Asia/Jakarta')->endOfDay();
        } else {
            $end = Carbon::now('Asia/Jakarta')->endOfDay();
            $start = Carbon::now('Asia/Jakarta')->subDays(6)->startOfDay();
            $startDate = $start->toDateString();
            $endDate = $end->toDateString();
        }

        $transaksiChart = Transaksi::selectRaw('DATE(tanggal) as tanggal, COUNT(*) as jumlah')
            ->whereBetween('tanggal', [$start, $end])
            ->groupByRaw('DATE(tanggal)')
            ->orderByRaw('DATE(tanggal)')
            ->get();

        $totalMenu = Menu::count();
        $transaksiHariIni = Transaksi::whereBetween('tanggal', [$todayStart, $todayEnd])->count();
        $pendapatanHariIni = Transaksi::whereBetween('tanggal', [$todayStart, $todayEnd])->sum('total');

        $menuWeek = Menu::whereBetween('created_at', [$weekStart, $weekEnd])->count();
        $menuPrevWeek = Menu::whereBetween('created_at', [$prevWeekStart, $prevWeekEnd])->count();
        $trendMenu = $menuPrevWeek > 0 ? (($menuWeek - $menuPrevWeek) / $menuPrevWeek) * 100 : ($menuWeek > 0 ? 100 : 0);

        $trxWeek = Transaksi::whereBetween('tanggal', [$weekStart, $weekEnd])->count();
        $trxPrevWeek = Transaksi::whereBetween('tanggal', [$prevWeekStart, $prevWeekEnd])->count();
        $trendTransaksi = $trxPrevWeek > 0 ? (($trxWeek - $trxPrevWeek) / $trxPrevWeek) * 100 : ($trxWeek > 0 ? 100 : 0);

        $pendWeek = Transaksi::whereBetween('tanggal', [$weekStart, $weekEnd])->sum('total');
        $pendPrevWeek = Transaksi::whereBetween('tanggal', [$prevWeekStart, $prevWeekEnd])->sum('total');
        $trendPendapatan = $pendPrevWeek > 0 ? (($pendWeek - $pendPrevWeek) / $pendPrevWeek) * 100 : ($pendWeek > 0 ? 100 : 0);

        return view('owner.dashboard', compact(
            'transaksiChart',
            'startDate',
            'endDate',
            'totalMenu',
            'transaksiHariIni',
            'pendapatanHariIni',
            'trendMenu',
            'trendTransaksi',
            'trendPendapatan'
        ));
    }
}
