<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Buku extends Model
{
    protected $table = 'buku';

    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'kode_buku',
        'judul',
        'penulis',
        'halaman',
        'jenis',
        'kategori',
        'deskripsi',
        'stok',
        'cover',
        'file',
    ];

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class);
    }

    public function detail_peminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class);
    }

    /**
     * image
     *
     * @return Attribute
     */
    // protected function cover(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($cover) => asset('http://localhost:8001/storage/cover/' . $cover),
    //     );
    // }

    // protected function file(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($file) => asset('http://localhost:8001/storage/file/' . $file),
    //     );
    // }
}
