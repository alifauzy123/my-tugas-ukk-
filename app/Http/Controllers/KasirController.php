<?php

namespace App\Http\Controllers;

use App\Models\Kasir;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function index()
    {
        $kasir = Kasir::orderBy('id')->get();
        return view('kasir.index', compact('kasir'));
    }

    public function create()
{
    return view('kasir.create');
}

    // dd($request->all());
    

public function store(Request $request)
{
    dd($request->all());
    $request->validate([
        'nama_lengkap' => 'required',
        'tanggal_lahir' => 'required',
        'jenis_kelamin' => 'required',
        'alamat' => 'required',
        'email' => 'required|email|unique:kasirs',
        'no_hp' => 'required',
        'username' => 'required|unique:kasirs',
        'password' => 'required|min:6'
    ]);

    Kasir::create([
        'nama_lengkap' => $request->nama_lengkap,
        'tanggal_lahir' => $request->tanggal_lahir,
        'jenis_kelamin' => $request->jenis_kelamin,
        'alamat' => $request->alamat,
        'email' => $request->email,
        'no_hp' => $request->no_hp,
        'username' => $request->username,
        'password' => Hash::make($request->password), // WAJIB HASH!
    ]);

    return redirect()->back()->with('success', 'Pendaftaran kasir berhasil!');
}


    public function update(Request $request, $id)
{
    // Validasi hanya status
    $request->validate([
        'status' => 'required|in:pending,approved,rejected',
    ]);

    // Ambil data kasir
    $kasir = Kasir::findOrFail($id);

    // Update hanya status
    $kasir->status = $request->status;
    $kasir->save();

    return redirect()->route('kasir.index')->with('success', 'Status kasir berhasil diperbarui.');
}
public function edit($id)
{
    $kasir = Kasir::findOrFail($id); // ambil data kasir berdasarkan ID
    return view('kasir.edit', compact('kasir')); // arahkan ke view edit
}


    public function show($id)
    {
        $kasir = Kasir::findOrFail($id);
        return view('kasir.show', compact('kasir'));
    }

    public function destroy($id)
    {
        $kasir = Kasir::findOrFail($id);
        $kasir->delete();

        return redirect()->route('kasir.index')->with('success', 'Data berhasil dihapus.');
    }

    public function acc($id)
{
    $user = User::findOrFail($id);
    $user->role = 'kasir';
    $user->save();

    // opsional: juga masukkan ke tabel kasir
    Kasir::create([
        'user_id' => $user->id,
        'nama' => $user->name,
    ]);

    return redirect()->back()->with('success', 'Kasir berhasil di ACC!');
}

public function showRegisterForm()
{
    return view('auth.registrasi');
}

public function register(Request $request)
{
    $request->validate([
        'nama_lengkap' => 'required|string|max:255',
        'tanggal_lahir' => 'required|date',
        'jenis_kelamin' => 'required',
        'alamat' => 'required|string',
        'email' => 'required|email|unique:kasirs,email',
        'no_hp' => 'required|string|max:20',
        'username' => 'required|string|max:100|unique:kasirs,username',
        'password' => 'required|string|min:6|confirmed',
    ]);

    Kasir::create([
        'nama_lengkap' => $request->nama_lengkap,
        'tanggal_lahir' => $request->tanggal_lahir,
        'jenis_kelamin' => $request->jenis_kelamin,
        'alamat' => $request->alamat,
        'email' => $request->email,
        'no_hp' => $request->no_hp,
        'username' => $request->username,
        'password' => bcrypt($request->password),
        'status' => 'pending'
    ]);

    return redirect()->route('login')->with('success', 'Registrasi berhasil, menunggu persetujuan admin.');
}






}   