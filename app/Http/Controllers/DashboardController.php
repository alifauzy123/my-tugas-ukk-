<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Pesanan;
use App\Models\Produk;
class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $today = Carbon::today();

    // Data grafik pesanan 7 hari terakhir
    $pesananChart = Pesanan::selectRaw('DATE(created_at) as tanggal, COUNT(*) as jumlah')
    ->where('created_at', '>=', now()->subDays(6))
    ->groupByRaw('DATE(created_at)')  // ← ganti ini!
    ->orderByRaw('DATE(created_at)')
    ->get();


    // Data tambahan
    $totalProduk = Produk::count();
    $totalStok   = Produk::sum('stok');
    $pesananHariIni = Pesanan::whereDate('created_at', $today)->count();

    return view('dashboard', compact('pesananChart', 'totalProduk', 'totalStok', 'pesananHariIni'));
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
