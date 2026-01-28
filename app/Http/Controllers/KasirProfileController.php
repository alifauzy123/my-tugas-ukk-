<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KasirProfileController extends Controller
{
    public function show()
    {
        $kasir = Auth::guard('kasir')->user();
        return view('kasir.profile.show', compact('kasir'));
    }

    public function update(Request $request)
    {
        $kasir = Auth::guard('kasir')->user();

        $validated = $request->validate([
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string|max:500',
            'telepon_kantor' => 'nullable|string|max:20',
            'nama_bank' => 'nullable|string|max:100',
            'nomor_rekening' => 'nullable|string|max:30',
            'atas_nama_rekening' => 'nullable|string|max:100',
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($kasir->avatar && Storage::disk('public')->exists($kasir->avatar)) {
                Storage::disk('public')->delete($kasir->avatar);
            }

            // Store new avatar
            $path = $request->file('avatar')->store('avatars/kasir', 'public');
            $validated['avatar'] = $path;
        }

        // Update kasir profile
        $kasir->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui',
            'avatar_url' => $kasir->avatar ? asset('storage/' . $kasir->avatar) : null,
        ]);
    }
}
