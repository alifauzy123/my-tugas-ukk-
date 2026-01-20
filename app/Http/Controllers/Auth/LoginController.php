<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kasir;
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
            return redirect()->route('dashboard');
        }

        // ✅ Cek kasir (guard kasir)
        $kasir = Kasir::where('username', $request->username)
            ->where('status', 'approved')
            ->first();

        if (!$kasir) {
            return back()->with('error', 'Akun tidak ditemukan atau belum disetujui.');
        }

        if (!Hash::check($request->password, $kasir->password)) {
            return back()->with('error', 'Password salah.');
        }

        // Login kasir
        Auth::guard('kasir')->login($kasir);
    
        return redirect()->route('dashboardkasir');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        Auth::guard('kasir')->logout();

        return redirect()->route('login');
    }
}
