<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['barang_id' => 1, 'kategori_id' => 1, 'barang_kode' => 'B01', 'barang_nama' => 'HP Oppo', 'harga_beli' => 2000000, 'harga_jual' => 2500000],
            ['barang_id' => 2, 'kategori_id' => 1, 'barang_kode' => 'B02', 'barang_nama' => 'Laptop Asus', 'harga_beli' => 7000000, 'harga_jual' => 8000000],
            ['barang_id' => 3, 'kategori_id' => 1, 'barang_kode' => 'B03', 'barang_nama' => 'TV Samsung', 'harga_beli' => 1500000, 'harga_jual' => 2000000],
            ['barang_id' => 4, 'kategori_id' => 2, 'barang_kode' => 'B04', 'barang_nama' => 'Gamis Wanita', 'harga_beli' => 40000, 'harga_jual' => 45000],
            ['barang_id' => 5, 'kategori_id' => 2, 'barang_kode' => 'B05', 'barang_nama' => 'Daster', 'harga_beli' => 50000, 'harga_jual' => 55000],
            ['barang_id' => 6, 'kategori_id' => 2, 'barang_kode' => 'B06', 'barang_nama' => 'Celana Kargo', 'harga_beli' => 60000, 'harga_jual' => 65000],
            ['barang_id' => 7, 'kategori_id' => 3, 'barang_kode' => 'B07', 'barang_nama' => 'Pensil', 'harga_beli' => 7000, 'harga_jual' => 7500],
            ['barang_id' => 8, 'kategori_id' => 3, 'barang_kode' => 'B08', 'barang_nama' => 'Penghapus', 'harga_beli' => 8000, 'harga_jual' => 8500],
            ['barang_id' => 9, 'kategori_id' => 3, 'barang_kode' => 'B09', 'barang_nama' => 'Buku', 'harga_beli' => 9000, 'harga_jual' => 9500],
            ['barang_id' => 10, 'kategori_id' => 4, 'barang_kode' => 'B10', 'barang_nama' => 'Sambal Terasi', 'harga_beli' => 1000, 'harga_jual' => 1500],
            ['barang_id' => 11, 'kategori_id' => 4, 'barang_kode' => 'B11', 'barang_nama' => 'Onigiri', 'harga_beli' => 11000, 'harga_jual' => 11500],
            ['barang_id' => 12, 'kategori_id' => 4, 'barang_kode' => 'B12', 'barang_nama' => 'Snack', 'harga_beli' => 11000, 'harga_jual' => 11500],
            ['barang_id' => 13, 'kategori_id' => 5, 'barang_kode' => 'B13', 'barang_nama' => 'Aqua', 'harga_beli' => 3000, 'harga_jual' => 5000],
            ['barang_id' => 14, 'kategori_id' => 5, 'barang_kode' => 'B14', 'barang_nama' => 'Sprite', 'harga_beli' => 7000, 'harga_jual' => 8000],
            ['barang_id' => 15, 'kategori_id' => 5, 'barang_kode' => 'B15', 'barang_nama' => 'Fanta', 'harga_beli' => 7000, 'harga_jual' => 8000],
        ];
        DB::table('m_barang')->insert($data);
    }
}
