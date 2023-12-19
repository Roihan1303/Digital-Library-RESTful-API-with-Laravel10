<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all posts
        $data = User::all();

        //return collection of posts as a resource
        return new ApiResource(true, 'List Data User', $data);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users,username',
            'password' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $data = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'major' => $request->major,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        //return response
        return new ApiResource(true, 'Data User Berhasil Ditambahkan!', $data);
    }

    public function show()
    {
        $data = auth()->user();

        //return single post as a resource
        return new ApiResource(true, 'Detail Data User', $data);
    }
    public function detail(User $user)
    {
        return new ApiResource(true, 'Detail Data User', $user);
    }

    public function update(Request $request)
    {
        $userId = auth()->user()->id;
        $data = User::find($userId);

        if ($request->password) {
            $validator = Validator::make($request->all(), [
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $data->update([
                'password'     => Hash::make($request->password),
            ]);
            // $data->password = Hash::make($request->password);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $data->update([
                'name'     => $request->name,
                'major'     => $request->major,
            ]);
        }
        return new ApiResource(true, 'Data User Berhasil Diubah!', $data);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return new ApiResource(true, 'Data User Berhasil Dihapus!', null);
    }

    public function loginUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!Auth::attempt($request->only(['username', 'password']))) {
            return response()->json([
                'status' => false,
                'message'   => 'Login Failed',
            ], 401);
        }

        $user = User::where('username', $request->username)->first();

        $token = $user->createToken('api-buku')->plainTextToken;
        // dd($token);
        // $response = Http::withHeaders([
        //     'Authorization' => 'Bearer ' . $token,
        // ])->get('http://localhost:8001/api/buku');
        return response()->json([
            'status' => true,
            'message'   => 'Login Success',
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil'
        ], 200);
    }
}
