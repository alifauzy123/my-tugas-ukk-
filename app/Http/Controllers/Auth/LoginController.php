<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kasir;
use App\Models\KasirLoginLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // ✅ Cek admin (guard web)
        if (Auth::guard('web')->attempt([
            'username' => $request->username,
            'password' => $request->password,
        ])) {
            $request->session()->regenerate();
            $user = Auth::guard('web')->user();
            if ($user && $user->role === 'owner') {
                return redirect()->route('dashboardowner')->with('success', 'Data sedang diproses');
            }
            return redirect()->route('dashboard')->with('success', 'Data sedang diproses');
        }

        // ✅ Cek kasir (guard kasir) - cek semua kasir terlebih dahulu
        $kasir = Kasir::where('username', $request->username)->first();

        // Jika kasir tidak ada sama sekali
        if (!$kasir) {
            return back()->with('error', 'Maaf username atau password salah');
        }

        // Jika kasir ada tapi di-reject
        if ($kasir->status === 'rejected') {
            return back()->with('rejected', 'Maaf data anda ditolak');
        }

        // Jika kasir ada tapi belum di-approve
        if ($kasir->status !== 'approved') {
            return back()->with('processing', 'Data anda sedang diproses');
        }

        // Jika kasir ada dan approved, tapi password salah
        if (!Hash::check($request->password, $kasir->password)) {
            return back()->with('error', 'Maaf username atau password salah');
        }

        // Login kasir
        Auth::guard('kasir')->login($kasir);
        $request->session()->regenerate();

        KasirLoginLog::create([
            'kasir_id' => $kasir->id,
            'action' => 'login',
            'logged_at' => Carbon::now('Asia/Jakarta'),
        ]);
    
        return redirect()->route('dashboardkasir')->with('success', 'Data sedang diproses');
    }

    public function logout(Request $request)
    {
        $kasir = Auth::guard('kasir')->user();

        if ($kasir) {
            KasirLoginLog::create([
                'kasir_id' => $kasir->id,
                'action' => 'logout',
                'logged_at' => Carbon::now('Asia/Jakarta'),
            ]);
        }

        Auth::guard('web')->logout();
        Auth::guard('kasir')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
