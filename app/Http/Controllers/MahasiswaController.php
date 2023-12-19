<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MahasiswaController extends Controller
{
    public function book()
    {
        $token = session('token');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get("http://localhost:8001/api/buku");
        $data = $response->json()['data'];

        $bookData = [];

        foreach ($data as $item) {
            if ($item['jenis'] === "Book") {
                $bookData[] = $item;
            }
        }

        $cartData = $this->cart();

        return view('mahasiswa/book', compact('bookData', 'cartData'));
    }

    public function ebook()
    {
        $token = session('token');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get("http://localhost:8001/api/buku");
        $data = $response->json()['data'];

        $ebookData = [];

        foreach ($data as $item) {
            if ($item['jenis'] === "E-Book") {
                $ebookData[] = $item;
            }
        }

        $cartData = $this->cart();

        return view('mahasiswa/ebook', compact('ebookData', 'cartData'));
    }

    public function show($kode_buku)
    {
        $token = session('token');
        $respons = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get("http://localhost:8001/api/buku/$kode_buku");
        $data = $respons->json()['data'];

        $cartData = $this->cart();

        return view('mahasiswa/detailBuku', compact('data', 'cartData'));
    }

    public function listPeminjaman()
    {
        $userId = session('userId');
        $token = session('token');
        $respons = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get("http://localhost:8001/api/listPeminjaman/$userId");
        $peminjaman = $respons->json()['data'];
        // $peminjaman = Peminjaman::where('status', '!=', 'Sudah Kembali')->where('username', session('username'))->get();
        $cartData = $this->cart();

        return view('mahasiswa/listPeminjaman', compact('peminjaman', 'cartData'));
    }

    public function historiPeminjaman()
    {
        $userId = session('userId');
        $token = session('token');
        $respons = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get("http://localhost:8001/api/historiPeminjaman/$userId");
        $peminjaman = $respons->json()['data'];
        $cartData = $this->cart();

        return view('mahasiswa/historiPeminjaman', compact('peminjaman', 'cartData'));
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
