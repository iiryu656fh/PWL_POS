<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelModel extends Model
{
    protected $table = 'm_level'; // mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'level_id'; // mendefinisikan primary key dari tabel yang digunakan oleh model ini
    protected $fillable = ['level_kode', 'level_nama']; // mendefinisikan kolom yang dapat diisi oleh model ini
}
