<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect(route('login'));
});

Route::get('login', [UserController::class, 'login'])->name('login');
Route::post('login', [UserController::class, 'prosesLogin'])->name('prosesLogin');
Route::get('register', [UserController::class, 'register'])->name('register');
Route::post('register', [UserController::class, 'prosesRegister'])->name('prosesRegister');
Route::post('logout', [UserController::class, 'logout'])->name('logout');
Route::get('DetailPeminjaman/{pinjamId}', [PeminjamanController::class, 'detailPeminjaman'])->name('detailPeminjaman');
Route::get('Profile', [UserController::class, 'profile'])->name('profile');
Route::post('EditProfile', [UserController::class, 'editProfile'])->name('editProfile');


Route::group(['middleware' => 'petugas'], function () {
    Route::get('DataBuku', [PetugasController::class, 'dataBuku'])->name('dataBuku');
    Route::get('DetailBukuu/{kode_buku}', [BukuController::class, 'show'])->name('detailBukuu');
    Route::post('tambahBuku', [BukuController::class, 'store'])->name('store');
    Route::get('downloadPDF/{kode_buku}', [BukuController::class, 'downloadPDF'])->name('downloadPDF');
    Route::put('update/{kode_buku}', [BukuController::class, 'updateStok'])->name('update');
    Route::delete('delete/{kode_buku}', [BukuController::class, 'delete'])->name('delete');
    Route::get('laporanPeminjaman', [PetugasController::class, 'laporanPeminjaman'])->name('laporanPeminjaman');
    Route::post('pengembalian/{pinjamId}', [PeminjamanController::class, 'pengembalian'])->name('pengembalian');
    Route::get('DataMahasiswa', [PetugasController::class, 'dataMahasiswa'])->name('dataMahasiswa');
    Route::get('DetailMahasiswa/{id}', [PetugasController::class, 'detailMahasiswa'])->name('detailMahasiswa');
    Route::delete('DeleteMahasiswa/{id}', [PetugasController::class, 'deleteMahasiswa'])->name('deleteMahasiswa');
    Route::post('TambahMahasiswa', [PetugasController::class, 'tambahMahasiswa'])->name('tambahMahasiswa');
});

Route::group(['middleware' => 'mahasiswa'], function () {
    Route::get('Book', [MahasiswaController::class, 'book'])->name('book');
    Route::get('E-Book', [MahasiswaController::class, 'ebook'])->name('ebook');
    Route::get('DetailBuku/{kode_buku}', [MahasiswaController::class, 'show'])->name('detailBuku');
    Route::get('downloadPDF/{kode_buku}', [BukuController::class, 'downloadPDF'])->name('downloadPDF');
    Route::delete('deleteCart/{keranjangId}', [PeminjamanController::class, 'deleteCart'])->name('deleteCart');
    Route::get('DetailKeranjang', [PeminjamanController::class, 'detailKeranjang'])->name('detailKeranjang');
    Route::post('tambahKeranjang', [PeminjamanController::class, 'tambahKeranjang'])->name('tambahKeranjang');
    Route::post('peminjaman', [PeminjamanController::class, 'tambahPeminjaman'])->name('peminjaman');
    Route::get('ListPeminjaman', [MahasiswaController::class, 'listPeminjaman'])->name('listPeminjaman');
    Route::post('prosesPengembalian/{pinjamId}', [PeminjamanController::class, 'prosesPengembalian'])->name('prosesPengembalian');
    Route::get('historiPeminjaman', [MahasiswaController::class, 'historiPeminjaman'])->name('historiPeminjaman');
});
