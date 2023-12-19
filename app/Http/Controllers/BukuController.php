<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\Hash;

class BukuController extends Controller
{
    public function show($kode_buku)
    {
        $token = session('token');
        $respons = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get("http://localhost:8001/api/buku/$kode_buku");
        $data = $respons->json()['data'];
        return view('petugas/detailBuku', compact('data'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_buku' => 'required',
            'judul' => 'required',
            'penulis' => 'required',
            'halaman' => 'required',
            'jenis' => 'required',
            'kategori' => 'required',
            'deskripsi' => 'required',
            'cover'     => 'required|image|mimes:jpeg,png|max:2048',
            'file'     => 'file|mimes:pdf|max:2048',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $cover = $request->file('cover');
        $base64Cover = base64_encode(file_get_contents($cover));

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $base64File = base64_encode(file_get_contents($file));
            $postData = [
                'kode_buku' => $request->kode_buku,
                'judul' => $request->judul,
                'penulis' => $request->penulis,
                'halaman' => $request->halaman,
                'jenis' => $request->jenis,
                'kategori' => $request->kategori,
                'deskripsi' => $request->deskripsi,
                'stok' => $request->stok,
                'cover' => $base64Cover,
                'file' => $base64File,
            ];
        } else {
            $postData = [
                'kode_buku' => $request->kode_buku,
                'judul' => $request->judul,
                'penulis' => $request->penulis,
                'halaman' => $request->halaman,
                'jenis' => $request->jenis,
                'kategori' => $request->kategori,
                'deskripsi' => $request->deskripsi,
                'stok' => $request->stok,
                'cover' => $base64Cover, // Kirim path file ke server (API)
            ];
        }

        // dd($postData);
        $token = session('token');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('http://localhost:8001/api/buku', $postData);

        if ($response->successful()) {
            return redirect()->route('dataBuku')->with('success', 'Buku Berhasil Ditambahkan');
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

    public function updateStok(Request $request, $kode_buku)
    {
        $token = session('token');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put("http://localhost:8001/api/buku/$kode_buku", [
            'stok' => $request->stok,
        ]);

        if ($response->successful()) {
            return redirect()->route('dataBuku')->with('success', 'Stok buku berhasil diperbarui');
        } else {
            $responseStatus = $response->status();
            $responseMessage = $response->json();

            if ($responseStatus == 422) {
                return redirect()->back()->withErrors($responseMessage)->withInput();
            } else {
                return redirect()->route('dataBuku')->with('error', 'Terjadi kesalahan saat mengirim permintaan ke API');
            }
        }
    }

    public function delete($kode_buku)
    {
        $token = session('token');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->delete("http://localhost:8001/api/buku/$kode_buku");
        if ($response->successful()) {
            return redirect()->route('dataBuku')->with('success', 'Buku berhasil dihapus');
        } else {
            $responseStatus = $response->status();
            $responseMessage = $response->json();

            if ($responseStatus == 422) {
                return redirect()->back()->withErrors($responseMessage)->withInput();
            } else {
                return redirect()->route('dataBuku')->with('error', 'Terjadi kesalahan saat mengirim permintaan ke API');
            }
        }
    }

    public function downloadPDF($kode_buku)
    {
        $token = session('token');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get("http://localhost:8001/api/buku/$kode_buku");
        $data = $response->json()['data'];
        $pdf = $data['file'];
        $name = $data['judul'];
        // Ambil konten file PDF dari URL API
        // $pdfContent = file_get_contents($pdf);
        $pdfContent = Http::get($pdf);

        // dd($pdfContent);
        if ($pdfContent->successful()) {
            $pdfData = $pdfContent->body();
            $filename = "$name.pdf";

            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            echo $pdfData;
        } else {
            return "Gagal mengunduh file PDF dari API.";
        }
    }
}
