<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $breadcrumb = (object)[
            'title' => 'Profil Pengguna',
            'list' => ['Home', 'Profil']
        ];

        $activeMenu = 'profil';

        $page = (object)[
            'title' => 'Profil Pengguna',
            'description' => 'Halaman untuk mengelola profil pengguna'
        ];

        return view('profil.index',  ['user' => $user, 'breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'page' => $page]);
    }

    public function import()
    {
        $user = Auth::user();
        return view('profil.import', compact('user'));
    }

    public function import_ajax(Request $request)
    {
        // Validasi input
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Cek apakah ada file di request
        if (!$request->hasFile('foto')) {
            return response()->json([
                'status' => false,
                'message' => 'File tidak ditemukan di request!',
                'msgField' => ['foto' => ['File tidak ditemukan.']]
            ]);
        }

        try {
            // Ambil data user
            $user = UserModel::find(Auth::id());

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User tidak ditemukan!',
                    'msgField' => ['foto' => ['User tidak ditemukan.']]
                ]);
            }

            // Hapus foto lama kalau ada
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            // Simpan foto baru
            $file = $request->file('foto');
            $filename = 'foto' . $user->user_id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('foto', $filename, 'public');

            // Update di database
            $user->update(['foto' => $path]);

            return response()->json([
                'status' => true,
                'message' => 'Foto profil berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal mengunggah foto profil: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat mengunggah foto.',
                'msgField' => ['foto' => ['Server error. Silakan coba lagi.']]
            ]);
        }
    }
}
