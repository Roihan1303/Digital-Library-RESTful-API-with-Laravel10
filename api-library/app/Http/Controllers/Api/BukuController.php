<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;

use App\Models\Buku;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all posts
        $post = Buku::all();

        //return collection of posts as a resource
        return new ApiResource(true, 'List Buku', $post);
    }

    public function dataBuku()
    {
        $data = Buku::all();

        $latestKodeBuku = 0;

        foreach ($data as $buku) {
            $kodeBuku = $buku->kode_buku;
            $urutan = (int) substr($kodeBuku, 3);

            if ($urutan > $latestKodeBuku) {
                $latestKodeBuku = $urutan;
            }
        }

        $urutanBaru = $latestKodeBuku + 1;

        $huruf = "BUK";
        $kodeBukuTerbaru = $huruf . sprintf("%02s", $urutanBaru);
        return view('dataBuku', compact('data', 'kodeBukuTerbaru'));
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'kode_buku' => 'required',
            'judul' => 'required',
            'penulis' => 'required',
            'halaman' => 'required',
            'jenis' => 'required',
            'kategori' => 'required',
            'deskripsi' => 'required',
            'cover'     => 'required',
            // 'cover'     => 'required|image|mimes:jpeg,png|max:2048',
            // 'file'     => 'file|mimes:pdf|max:2048',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        // $cover = $request->file('cover');
        // $coverPath = 'public/cover/' . $request->judul . '.jpg';
        // $cover->storeAs($coverPath);

        $coverData = base64_decode($request->cover);

        $coverPath = 'public/cover/' . $request->judul . '.jpg'; // Atur nama file yang sesuai

        if (Storage::exists($coverPath)) {
            Storage::delete($coverPath);
        }

        Storage::put($coverPath, $coverData);



        //upload file
        if ($request->file) {
            // $file = $request->file('cover');
            // $filePath = 'public/cover/' . $request->judul . '.jpg';
            // $file->storeAs($filePath);

            $fileData = base64_decode($request->file);
            $filePath = 'public/file/' . $request->judul . '.pdf'; // Atur nama file yang sesuai
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }
            Storage::put($filePath, $fileData);

            //create post
            $post = Buku::create([
                'kode_buku' => $request->kode_buku,
                'judul' => $request->judul,
                'penulis' => $request->penulis,
                'halaman' => $request->halaman,
                'jenis' => $request->jenis,
                'kategori' => $request->kategori,
                'deskripsi' => $request->deskripsi,
                'stok' => $request->stok,
                'cover'     => 'http://192.168.32.30:8000/storage/cover/' . pathinfo($coverPath, PATHINFO_FILENAME) . '.jpg',
                'file'     => 'http://192.168.32.30:8000/storage/file/' . pathinfo($filePath, PATHINFO_FILENAME) . '.pdf',
            ]);

            // return response
            return new ApiResource(true, 'Data Buku Berhasil Ditambahkan!', $post);
            // return redirect()->route('dataBuku')->with('success', 'Buku Berhasil Ditambahkan');
        } else {
            //create post
            $post = Buku::create([
                'kode_buku' => $request->kode_buku,
                'judul' => $request->judul,
                'penulis' => $request->penulis,
                'halaman' => $request->halaman,
                'jenis' => $request->jenis,
                'kategori' => $request->kategori,
                'deskripsi' => $request->deskripsi,
                'stok' => $request->stok,
                'cover'     => 'http://192.168.32.30:8000/storage/cover/' . pathinfo($coverPath, PATHINFO_FILENAME) . '.jpg',
            ]);

            //return response
            return new ApiResource(true, 'Data Buku Berhasil Ditambahkan!', $post);
            // return redirect()->route('dataBuku')->with('success', 'Buku Berhasil Ditambahkan');
        }
    }

    public function show($kode_buku)
    {
        //find post by kode_buku
        $post = Buku::where('kode_buku', $kode_buku)->first();

        //return single post as a resource
        return new ApiResource(true, 'Detail Data Buku!', $post);
        // return view('detailBuku', compact('data'));
    }

    public function showw($kode_buku)
    {
        //find post by kode_buku
        $data = Buku::where('kode_buku', $kode_buku)->first();

        //return single post as a resource
        // return new ApiResource(true, 'Detail Data Buku!', $post);
        // return view('detailBuku', compact('data'));
    }

    public function update(Request $request, $kode_buku)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'stok' => 'required|numeric',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find post by kode_buku
        $post = Buku::where('kode_buku', $kode_buku)->first();

        $post->update([
            'stok'     => $request->stok,
        ]);

        //return response
        return new ApiResource(true, 'Stok Buku Berhasil Diubah!', $post);
        // return redirect()->route('dataBuku')->with('success', 'Stok buku berhasil diperbarui');
    }

    public function destroy($kode_buku)
    {
        //find post by ID
        $post = Buku::where('kode_buku', $kode_buku)->first();

        //delete image
        Storage::delete('public/cover/' . basename($post->cover));
        Storage::delete('public/file/' . basename($post->file));

        //delete post
        $post->delete();

        //return response
        return new ApiResource(true, 'Data Buku Berhasil Dihapus!', null);
        // return redirect()->route('dataBuku')->with('success', 'Buku berhasil dihapus');
    }
}
