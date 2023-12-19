<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PetugasMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if (auth()->check() && auth()->user()->role === 'Petugas') {
        //     return $next($request);
        // }
        if (session('role') == 'Petugas') {
            return $next($request);
        }

        return redirect(route('login'))->with('failed', 'Akses Ditolak');
        // abort(403, 'Unauthorized'); // Jika pengguna bukan admin, maka berikan respon Forbidden (HTTP 403).

    }
}
