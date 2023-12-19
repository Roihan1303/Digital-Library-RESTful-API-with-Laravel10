<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjaman';
    protected $fillable = [
        'kode_pinjam',
        'users_id',
        'tgl_pinjam',
        'batas_pinjam',
        'tgl_kembali',
        'denda',
        'status',
        'petugas',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
    
    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class);
    }
}
