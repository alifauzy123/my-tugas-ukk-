<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kasir;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Tampilkan halaman register
    public function show()
    {
        return view('auth.register');
    }

    // Simpan data registrasi
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'email' => 'required|email|unique:kasirs,email',
            'no_hp' => 'required',
            'username' => 'required|unique:kasirs,username',
            'password' => 'required|min:5|confirmed',
        ]);

        Kasir::create([
            'nama_lengkap' => $request->nama_lengkap,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat'        => $request->alamat,
            'email'         => $request->email,
            'no_hp'         => $request->no_hp,
            'username'      => $request->username,
            'password'      => Hash::make($request->password),
            'status'        => 'pending' // default registrasi
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Tunggu persetujuan admin.');
    }
}
