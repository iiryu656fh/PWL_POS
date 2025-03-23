<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role = ''): Response
    {
        $user = $request->user();  // ambil data user yg login
                                    //  fungsi user() diambil dari USerModel.php
        if($user->hasRole($role)){ // cek apakah user memiliki role yang diinginkan
            return $next($request);
        }
        // Jika tiak punya role, maka tampilkan error 403
        abort(402, 'Forbidden. Kamu tidak punya akses ke halaman ini');
    }
}
