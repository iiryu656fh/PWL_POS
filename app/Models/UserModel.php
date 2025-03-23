<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable; // implementasi class Authenticatable

class UserModel extends Model
{
    use HasFactory;

    protected $table = 'm_user'; // mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'user_id'; // mendefinisikan primary key dari tabel yang digunakan oleh model ini
    protected $fillable = [
        'level_id',
        'username',
        'nama',
        'password',
        'created_at',
        'updated_at'
    ];

    protected $hidden = ['password']; // Jangan ditampilkan saat select

    protected $casts = [ 'password' => 'hashed' ]; // casting password agar otomatis di hash

    /**
     * Relasi ke tabel level
     */
 
    public function level(): BelongsTo {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    /**
     * Mendapatkan nama role
     */
    public function getRoleName(): string {
        return $this->level->level_name;
    }

    /**
     * Cek apakah user memiliki role tertentu
     */
    public function hasRole(string $role): bool {
        return $this->level->level_kode == $role;
    }
}
