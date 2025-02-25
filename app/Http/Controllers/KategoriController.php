<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        // $data = [
        //     'kategori_kode' => 'K06',
        //     'kategori_nama' => 'Buku',
        //     'created_at' => now()
        // ];
        // DB::table('m_kategori')->insert($data);
        // return 'Data berhasil ditambahkan';

        // $row = DB::table('m_kategori')->where('kategori_kode', 'K06')->update(['kategori_nama' => 'Buku Tulis']);
        // return 'Data berhasil diupdate. Jumlah data yang diupdate: ' . $row . ' baris';

        // $row = DB::table('m_kategori')->where('kategori_kode', 'K06')->delete();
        // return 'Data berhasil dihapus. Jumlah data yang dihapus: ' . $row . ' baris';

        $data = DB::table('m_kategori')->get();
        return view('kategori', ['data' => $data]);
    }
}
