<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

// use App\Models\DetailPeminjaman;

use App\Http\Resources\ApiResource;
use App\Models\Buku;
use App\Models\DetailPeminjaman;
use App\Models\Keranjang;
use App\Models\Peminjaman;
use App\Models\User;
// use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class PeminjamanController extends Controller
{
    public function listPeminjaman($userId)
    {
        $peminjaman = Peminjaman::with(['users', 'detailPeminjaman', 'detailPeminjaman.buku'])->where('status', '!=', 'Sudah Kembali')->where('users_id', $userId)->get();
        return new ApiResource(true, 'List Peminjaman', $peminjaman);
    }

    public function historiPeminjaman($userId)
    {
        $peminjaman = Peminjaman::with(['users', 'detailPeminjaman', 'detailPeminjaman.buku'])->where('status', 'Sudah Kembali')->where('users_id', $userId)->get();
        return new ApiResource(true, 'Histori Peminjaman', $peminjaman);
    }

    public function laporanPeminjaman()
    {
        $peminjaman = Peminjaman::with(['users', 'detailPeminjaman', 'detailPeminjaman.buku'])->where('status', '!=', 'Menunggu')->get();
        return new ApiResource(true, 'Laporan Peminjaman', $peminjaman);
    }

    public function konfirmasiPengembalian()
    {
        $peminjaman = Peminjaman::with(['users', 'detailPeminjaman', 'detailPeminjaman.buku'])->where('status', 'Menunggu')->get();
        return new ApiResource(true, 'Konfirmasi Pengembalian', $peminjaman);
    }

    public function deleteCart(Keranjang $keranjang)
    {
        $keranjang->delete();

        // return redirect()->route('book');
        return new ApiResource(true, 'Buku Berhasil Dihapus', null);
    }

    public function tambahKeranjang(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'stok' => 'required',
            'jumlah' => 'required',
            'userId' => 'required',
            'bukuId' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $updateStok = $request->stok - $request->jumlah;
        if ($updateStok < 0) {
            return response()->json([
                'status' => false,
                'message' => 'Stok tidak tersedia'
            ]);
        } else {
            $data = Keranjang::create([
                'users_id' => $request->userId,
                'buku_id' => $request->bukuId,
                'jumlah' => $request->jumlah
            ]);
            return new ApiResource(true, 'Tambah Keranjang', $data);
        }
    }

    public function tambahPeminjaman(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jumlah' => 'required',
            'userId' => 'required',
            'bukuId' => 'required',
            'tgl_pinjam' => 'required',
            'batas_pinjam' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $latestPeminjaman = Peminjaman::latest('kode_pinjam')->first();

        if (!$latestPeminjaman) {
            $urutan = 1;
        } else {
            $kodePinjam = $latestPeminjaman->kode_pinjam;
            $urutan = (int) substr($kodePinjam, 3);
            $urutan++;
        }

        $huruf = "PJM";
        $kodePinjam = $huruf . sprintf("%02s", $urutan);

        $peminjaman = Peminjaman::create([
            'kode_pinjam' => $kodePinjam,
            'users_id' => $request->userId,
            'tgl_pinjam' => $request->tgl_pinjam,
            'batas_pinjam' => $request->batas_pinjam,
            'status' => 'Belum Kembali'
        ]);

        for ($i = 0; $i < count($request->bukuId); $i++) {
            $bukuId2 = $request->bukuId[$i];
            $jumlah2 = $request->jumlah[$i];

            $buku = Buku::where('id', $bukuId2)->get();
            foreach ($buku as $dataBuku) {
                $stok = $dataBuku->stok;
            }

            $updateStok = $stok - $jumlah2;

            // craate detail peminjaman
            $detailPeminjaman = new DetailPeminjaman();
            $detailPeminjaman->peminjaman_id = $peminjaman->id;
            $detailPeminjaman->buku_id = $bukuId2;
            $detailPeminjaman->jumlah = $jumlah2;
            $detailPeminjaman->save();

            // Update stok buku
            $this->updateStokBuku($bukuId2, $updateStok);
        }

        $keranjang = Keranjang::where('users_id', $request->userId);
        $keranjang->delete();

        return new ApiResource(true, 'Tambah Peminjaman', $peminjaman);
    }

    public function prosesPengembalian($pinjamId)
    {
        $tgl_kembali = now()->toDateString();
        $pengembalian = Peminjaman::where('id', $pinjamId)->first();
        $pengembalian->update([
            'tgl_kembali' => $tgl_kembali,
            'status' => 'Menunggu',
        ]);

        return new ApiResource(true, 'Pengembalian', $pengembalian);
    }

    public function detailPeminjaman($pinjamId)
    {
        $peminjaman = Peminjaman::with(['users', 'detailPeminjaman', 'detailPeminjaman.buku'])->where('id', $pinjamId)->first();
        return new ApiResource(true, 'Peminjaman', $peminjaman);
    }

    public function pengembalian(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pinjamId' => 'required',
            'denda' => 'required',
            'namaPetugas' => 'required',
            'bukuId' => 'required',
            'jumlah' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $pengembalian = Peminjaman::where('id', $request->pinjamId)->first();
        $pengembalian->update([
            'denda' => $request->denda,
            'status' => 'Sudah Kembali',
            'petugas' => $request->namaPetugas,
        ]);

        for ($i = 0; $i < count($request->bukuId); $i++) {
            $bukuId2 = $request->bukuId[$i];
            $jumlah2 = $request->jumlah[$i];

            // Get Stok Buku
            $buku = Buku::where('id', $bukuId2)->get();
            foreach ($buku as $dataBuku) {
                $stok = $dataBuku->stok;
            }
            $updateStok = $stok + $jumlah2;

            // Update stok buku
            $this->updateStokBuku($bukuId2, $updateStok);
        }

        return new ApiResource(true, 'Pengembalian Buku', $pengembalian);
    }

    public function cart($userId)
    {
        $cart = Keranjang::with(['buku', 'users'])->where('users_id', $userId)->get();
        return new ApiResource(true, 'Cart', $cart);
    }

    private function updateStokBuku($bukuId, $updateStok)
    {
        // Update stok buku
        Buku::where('id', $bukuId)->update([
            'stok' => $updateStok,
        ]);
    }
}
