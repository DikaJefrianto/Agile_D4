<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class KaryawanOnly
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->role === 'karyawan') {
            abort(403, 'Hanya Karyawan yang dapat mengakses halaman ini');
        }

        return $next($request);
    }
}
