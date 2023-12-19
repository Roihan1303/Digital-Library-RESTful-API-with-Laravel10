<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class DetailPeminjaman extends Model
{
    use HasFactory;
    protected $table = 'detail_peminjaman';
    protected $fillable = [
        'peminjaman_id',
        'buku_id',
        'jumlah',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}
