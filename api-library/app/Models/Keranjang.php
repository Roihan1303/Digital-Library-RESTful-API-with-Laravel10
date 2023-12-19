<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Keranjang extends Model
{
    use HasFactory;
    protected $table = 'keranjang';
    // protected $primaryKey = 'kode_buku';
    protected $fillable = [
        'users_id',
        'buku_id',
        'jumlah',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}
