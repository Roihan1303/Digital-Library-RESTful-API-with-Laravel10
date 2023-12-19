<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function logout()
    {
        $token = session('token');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('http://localhost:8001/api/users/logout');

        $message = $response->json()['message'];
        if ($message == 'Logout berhasil') {
            session()->flush();
            return redirect(route('login'));
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

    public function prosesLogin(Request $request)
    {
        $response = Http::post("http://localhost:8001/api/users/login", [
            'username' => $request->username,
            'password' => $request->password,
        ]);
        if ($response->json()['message'] == 'Login Failed') {
            return redirect(route('login'))->with('failed', 'Username atau password salah!');
        } else {
            $token = $response->json()['token'];
            $responseUser = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://localhost:8001/api/users/show');
            $user = $responseUser->json()['data'];
            session(['token' => $token]);
            session(['userId' => $user['id']]);
            session(['username' => $user['username']]);
            session(['name' => $user['name']]);
            session(['role' => $user['role']]);

            if ($user['role'] == 'Petugas') {
                return redirect(route('dataBuku'))->with('success', 'Selamat Datang ' . $user['name']);
                // return redirect(route('dataMahasiswa'))->with('success', 'Selamat Datang ' . $user['name']);
            } else {
                return redirect(route('book'))->with('success', 'Selamat Datang ' . $user['name']);
            }
        }
    }

    public function prosesRegister(Request $request)
    {
        if ($request->password != $request->repassword) {
            return redirect(route('register'))->with('failed', 'Wrong Password');
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
                return redirect(route('login'))->with('success', 'Register Success');
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
    }

    public function profile()
    {
        $token = session('token');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://localhost:8001/api/users/show');
        $user = $response->json()['data'];

        $cartData = $this->cart();
        return view('profile', compact('user', 'cartData'));
    }

    public function editProfile(Request $request)
    {
        $data = [];
        if ($request->password) {
            if ($request->password != $request->repassword) {
                return redirect(route('profile'))->with('failed', 'Wrong Password!');
            } else {
                $data = [
                    'password' => $request->password,
                ];
            }
        } else {
            $data = [
                'name' => $request->name,
                'major' => $request->major,
            ];
        }

        $token = session('token');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put('http://localhost:8001/api/users', $data);

        if ($response->successful()) {
            return redirect(route('profile'))->with('success', 'Profile Berhasil Diupdate');
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
