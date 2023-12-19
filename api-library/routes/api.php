<?php

use App\Http\Controllers\Api\BukuController;
use App\Http\Controllers\Api\PeminjamanController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('users/login', [UserController::class, 'loginUser'])->name('login');
Route::post('users', [UserController::class, 'store']);
Route::get('cart/{userId}', [PeminjamanController::class, 'cart']);
Route::get('detailPeminjaman/{pinjamId}', [PeminjamanController::class, 'detailPeminjaman']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('/buku', BukuController::class);
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/show', [UserController::class, 'show']);
    Route::put('users', [UserController::class, 'update']);
    Route::post('users/logout', [UserController::class, 'logout']);
    Route::group(['middleware' => 'petugas'], function () {
        Route::get('users/{user}', [UserController::class, 'detail']);
        Route::delete('users/{user}', [UserController::class, 'destroy']);
        Route::get('laporanPeminjaman', [PeminjamanController::class, 'laporanPeminjaman']);
        Route::get('konfirmasiPengembalian', [PeminjamanController::class, 'konfirmasiPengembalian']);
        Route::post('pengembalian', [PeminjamanController::class, 'pengembalian']);
    });
    Route::group(['middleware' => 'mahasiswa'], function () {
        Route::get('listPeminjaman/{userId}', [PeminjamanController::class, 'listPeminjaman']);
        Route::get('historiPeminjaman/{userId}', [PeminjamanController::class, 'historiPeminjaman']);
        Route::post('tambahKeranjang', [PeminjamanController::class, 'tambahKeranjang']);
        Route::delete('deleteCart/{keranjang}', [PeminjamanController::class, 'deleteCart']);
        Route::post('tambahPeminjaman', [PeminjamanController::class, 'tambahPeminjaman']);
        Route::put('prosesPengembalian/{pinjamId}', [PeminjamanController::class, 'prosesPengembalian']);
    });
});
