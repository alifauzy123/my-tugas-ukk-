<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuRiwayatHarga;

class OwnerMenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('kategori')->get();
        return view('owner.menu.index', compact('menus'));
    }

    public function historyHarga($id)
    {
        $history = MenuRiwayatHarga::where('menu_id', $id)
            ->orderByDesc('created_at')
            ->get();

        return response()->json($history);
    }
}
