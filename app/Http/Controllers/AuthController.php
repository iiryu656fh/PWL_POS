<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Exception;

class AuthController extends Controller
{
    public function login(){
        if(Auth::check()){ // Jika sudah login, maka redirect ke halaman home
            return redirect('/');
        }
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $credentials = $request->only('username', 'password');

            if (Auth::attempt($credentials)) {
                return response()->json([
                    'status' => true,
                    'message' => 'Login Berhasil',
                    'redirect' => url('/')
                ]);
            } 
            
            return response()->json([
                'status' => false,
                'message' => 'Login Gagal'
            ]);
        }
        return redirect('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }

    public function register(){
        try {
            $levels = LevelModel::where('level_nama', '!=', 'Administrator')->get();
            return view('auth.register', compact('levels'));
        } catch (Exception $e) {
            return redirect('login')->with('error', 'Gagal mengambil data level: ' . $e->getMessage());
        }
    }

    public function postRegister(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|min:3|max:50|unique:m_user',
            'nama' => 'required|string|min:3|max:100',
            'password' => 'required|string|min:6|confirmed',
            'level_id' => 'required|exists:m_level,level_id|not_in:' .  LevelModel::where('level_nama', 'Administrator')->value('level_id')
        ], [
            'level_id.not_in' => 'Level tidak valid / tidak boleh diakses'
        ]);
        if ($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 422);
        }
        try {
            UserModel::create([
                'username' => $request->username,
                'nama' => $request->nama,
                'password' => Hash::make($request->password),
                'level_id' => $request->level_id
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Registrasi Berhasil',
                'redirect' => url('login')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Registrasi Gagal: ' . $e->getMessage()
            ], 500);
        }
    }
}
