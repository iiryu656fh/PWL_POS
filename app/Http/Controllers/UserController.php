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

    public function list(Request $request){
        $user = UserModel::select('user id', 'username', 'nama', 'level_id')->with('level');

        return DataTables::of($user)
            // menambahkan kolom index / no urut (Default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColmn('aksi', function($user){ //menambahkan kolom aksi
                $btn = '<a href="'.url('/user/' . $user->user_id).'" class="btn btn-info btn-sm">Detail</a>';
                $btn .= '<a href="'.url('/user/' . $user->user_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a>';
                $btn .= '<form class="d-inline-block" method="POST" action="'.url('/user/' . $user->user_id).'">'
                            . csrf_field() . method_field('DELETE') . 
                            '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah anda yakin menghapus data ini?\');
                            ">Hapus</button></form>';
                return $btn;        
            })
            ->rawColumns(['aksi']) //menandakan kolom tersebut adalah html
            ->make(true);
    }

    // Menampilkan halaman form tambah user
    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list' => ['Home', 'User', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah user baru'
        ];

        $level = LevelModel::all(); // ambil data level untuk ditampilkan di form
        $acttiveMenu = 'user'; // set menu yang aktif
        return view('user.create', ['breadcrumb' => $breadcrumb, 'activeMenu' => $acttiveMenu, 'page' => $page, 'level' => $level]);
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
