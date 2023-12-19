<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PeminjamanController extends Controller
{
    public function deleteCart($keranjangId)
    {
        $token = session('token');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->delete("http://localhost:8001/api/deleteCart/$keranjangId");
        if ($response->successful()) {
            return redirect()->route('book');
        }
    }

    public function detailKeranjang()
    {
        $cartData = $this->cart();
        return view('mahasiswa/detailKeranjang', compact('cartData'));
    }

    public function tambahKeranjang(Request $request)
    {
        $updateStok = $request->stok - $request->jumlah;
        if ($updateStok < 0) {
            return redirect(route('book'))->with('failed', 'Stok Buku Tidak Tersedia');
        } else {
            $data = [
                'stok' => $request->stok,
                'jumlah' => $request->jumlah,
                'userId' => $request->userId,
                'bukuId' => $request->bukuId,
            ];

            $token = session('token');
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post("http://localhost:8001/api/tambahKeranjang", $data);
            if ($response->successful()) {
                return redirect(route('book'))->with('success', 'Buku Berhasil Ditambahkan Ke Keranjang');
            }
        }
    }

    public function tambahPeminjaman(Request $request)
    {
        $data = [
            'jumlah' => $request->jumlah,
            'userId' => $request->userId,
            'bukuId' => $request->bukuId,
            'tgl_pinjam' => $request->tgl_pinjam,
            'batas_pinjam' => $request->batas_pinjam,
        ];

        $token = session('token');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post("http://localhost:8001/api/tambahPeminjaman", $data);
        if ($response->successful()) {
            return redirect(route('book'))->with('success', 'Peminjaman Berhasil');
        }
    }

    public function prosesPengembalian($pinjamId)
    {
        $token = session('token');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put("http://localhost:8001/api/prosesPengembalian/$pinjamId");
        if ($response->successful()) {
            return redirect(route('listPeminjaman'));
        } else {
            $responseStatus = $response->status();
            $responseMessage = $response->json();

            if ($responseStatus == 422) {
                return response()->json($responseMessage, 422);
            } else {
                return response()->json(['message' => 'Terjadi kesalahan saat mengirim permintaan ke API'], $responseStatus);
            }
        }
    }

    public function detailPeminjaman($pinjamId)
    {
        $token = session('token');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get("http://localhost:8001/api/detailPeminjaman/$pinjamId");
        if ($response->successful()) {
            $peminjaman = $response->json()['data'];
            $cartData = $this->cart();
            return view('detailPeminjaman', compact('peminjaman', 'cartData'));
        } else {
            $responseStatus = $response->status();
            $responseMessage = $response->json();

            if ($responseStatus == 422) {
                return response()->json($responseMessage, 422);
            } else {
                return response()->json(['message' => 'Terjadi kesalahan saat mengirim permintaan ke API'], $responseStatus);
            }
        }
    }

    public function pengembalian(Request $request, $pinjamId)
    {
        $data = [
            'pinjamId' => $pinjamId,
            'denda' => $request->denda,
            'namaPetugas' => $request->namaPetugas,
            'bukuId' => $request->bukuId,
            'jumlah' => $request->jumlah,
        ];

        $token = session('token');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post("http://localhost:8001/api/pengembalian", $data);
        if ($response->successful()) {
            return redirect(route('laporanPeminjaman'))->with('success', 'Buku Berhasil Dikembalikan');
        } else {
            $responseStatus = $response->status();
            $responseMessage = $response->json();

            if ($responseStatus == 422) {
                return response()->json($responseMessage, 422);
            } else {
                return response()->json(['message' => 'Terjadi kesalahan saat mengirim permintaan ke API'], $responseStatus);
            }
        }
    }

    private function cart()
    {
        $token = session('token');
        $userId = session('userId');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get("http://localhost:8001/api/cart/$userId");
        $cartData = $response->json()['data'];
        return $cartData;
    }
}
