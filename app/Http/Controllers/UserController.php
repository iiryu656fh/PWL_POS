<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;
use App\Models\LevelModel;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];

        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];

        $acttiveMenu = 'user'; // set menu yang aktif

        return view('user.index', ['breadcrumb' => $breadcrumb, 'activeMenu' => $acttiveMenu, 'page' => $page]);
        // $user = UserModel::with('level')->get();
        // return view('user', ['data' => $user]);
    }

    // public function tambah()
    // {
    //     return view('user_tambah');
    // }

    // public function tambah_simpan(Request $request)
    // {
    //     UserModel::create([
    //         'username' => $request->username,
    //         'nama' => $request->nama,
    //         'password' => Hash::make($request->password),
    //         'level_id' => $request->level_id
    //     ]);
    //     return redirect('/user');
    // }

    // public function ubah($user_id){
    //     $user = UserModel::find($user_id);
    //     return view('user_ubah', ['data' => $user]);
    // }

    // public function ubah_simpan(Request $request, $user_id){
    //     $user = UserModel::find($user_id);

    //     $user->username = $request->username;
    //     $user->nama = $request->nama;
    //     $user->password = Hash::make($request->password);
    //     $user->level_id = $request->level_id;

    //     $user->save();

    //     return redirect('/user');
    // }

    // public function hapus($user_id){
    //     $user = UserModel::find($user_id);
    //     $user->delete();
        
    //     return redirect('/user');
    // }
    
}
