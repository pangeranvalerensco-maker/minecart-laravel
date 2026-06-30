<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsSeller
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->is_seller) {
            return $next($request);
        }

        return redirect('/')->with('error', 'Akses ditolak. Halaman ini khusus untuk penjual.');
    }
}
