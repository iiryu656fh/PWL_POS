<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriModel extends Model
{
    protected $table = 'm_kategori'; // mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'kategori_id'; // mendefinisikan primary key tabel
    protected $fillable = ['kategori_kode', 'kategori_nama']; // mendefinisikan kolom yang dapat diisi oleh model ini
}
