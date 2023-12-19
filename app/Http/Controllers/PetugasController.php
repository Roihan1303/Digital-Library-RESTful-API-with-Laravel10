<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PetugasController extends Controller
{
    public function dataBuku()
    {
        // Lakukan permintaan HTTP ke API
        $token = session('token');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get("http://localhost:8001/api/buku");

        // Ambil data dari respons JSON
        $data = $response->json()['data'];

        $latestKodeBuku = 0;

        foreach ($data as $buku) {
            $kodeBuku = $buku['kode_buku'];
            $urutan = (int) substr($kodeBuku, 3);

            if ($urutan > $latestKodeBuku) {
                $latestKodeBuku = $urutan;
            }
        }

        $urutanBaru = $latestKodeBuku + 1;

        $huruf = "BUK";
        $kodeBukuTerbaru = $huruf . sprintf("%02s", $urutanBaru);

        // dd($token);
        return view('petugas/databuku', compact('data', 'kodeBukuTerbaru'));
    }

    public function laporanPeminjaman()
    {
        $token = session('token');
        $respons = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get("http://localhost:8001/api/laporanPeminjaman");
        $laporan = $respons->json()['data'];
        // $laporan = Peminjaman::where('status', '!=', 'Menunggu')->get();
        $respons = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get("http://localhost:8001/api/konfirmasiPengembalian");
        $konfirmasi = $respons->json()['data'];
        // $konfirmasi = Peminjaman::where('status', 'Menunggu')->get();

        return view('petugas/laporanPeminjaman', compact('laporan', 'konfirmasi'));
        unset($laporan);
        unset($konfirmasi);
    }

    public function dataMahasiswa()
    {
        $token = session('token');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://localhost:8001/api/users');

        $data = $response->json()['data'];

        $dataMahasiswa = [];

        foreach ($data as $item) {
            if ($item['role'] === "Mahasiswa") {
                $dataMahasiswa[] = $item;
            }
        }

        return view('petugas/dataMahasiswa', compact('dataMahasiswa'));
    }

    public function detailMahasiswa($id)
    {
        $token = session('token');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get("http://localhost:8001/api/users/{$id}");

        $data = $response->json()['data'];

        return view('petugas/detailMahasiswa', compact('data'));
    }

    public function deleteMahasiswa($id)
    {
        $token = session('token');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->delete("http://localhost:8001/api/users/{$id}");

        if ($response->successful()) {
            return redirect(route('dataMahasiswa'))->with('success', 'Data mahasiswa berhasil dihapus');
        }
    }

    public function tambahMahasiswa(Request $request)
    {
        if ($request->password != $request->repassword) {
            return redirect(route('dataMahasiswa'))->with('failed', 'Wrong Password!');
        } else {
            $data = [
                'username' => $request->username,
                'password' => $request->password,
                'name' => $request->name,
                'major' => $request->major,
                'email' => $request->email,
                'role' => 'Mahasiswa',
            ];

            $response = Http::post("http://localhost:8001/api/users", $data);
            if ($response->successful()) {
                return redirect(route('dataMahasiswa'))->with('success', 'Tambah Mahasiswa Berhasil');
            }
        }
    }
}
