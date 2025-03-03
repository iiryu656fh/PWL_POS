<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // // tambah data user dengn Eloquent Model
        // $user = [
        //     'nama' => 'Pelanggan Pertama',
        // ];
        // UserModel::where('username', 'customer 1')->update($user); //update data user
        // $data = [
        //     'level_id' => 2,
        //     'username' => 'manager_tiga',
        //     'nama' => 'Manager 3',
        //     'password' => Hash::make('12345'),
        // ];
        // UserModel::create($data); // insert data user
        // // coba akses model UserModel

        $user = UserModel::where('level_id', 2)->count();
        //dd($user);
        return view('user', ['data' => $user]);
    }
}
