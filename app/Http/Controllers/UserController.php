<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // tambah data user dengn Eloquent Model
        $user = [
            'nama' => 'Pelanggan Pertama',
        ];
        UserModel::where('username', 'customer 1')->update($user); //update data user
        
        // coba akses model UserModel
        $user = UserModel::all(); // ambil semua data dari tabel m_user
        return view('user', ['user' => $user]);
    }
}
