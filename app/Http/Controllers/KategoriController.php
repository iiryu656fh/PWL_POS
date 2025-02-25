<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $data = [
            'kategori_kode' => 'K06',
            'kategori_nama' => 'Buku',
            'created_at' => now()
        ];
        DB::table('m_kategori')->insert($data);
        return 'Data berhasil ditambahkan';
    }
}
