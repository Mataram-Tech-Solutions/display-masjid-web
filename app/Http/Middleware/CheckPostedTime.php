<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;


class CheckPostedTime
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    
     public function handle($request, Closure $next)
     {
         // Bypass middleware untuk halaman 'waiting-rtc'
         if ($request->routeIs('waiting-rtc.index')) {
             return $next($request);
         }
     
         // Periksa apakah 'server_time' ada di cache
         if (!Cache::has('server_time')) {
             // Jika belum ada waktu, arahkan ke halaman "waktu belum diset"
             return redirect()->route('waiting-rtc.index');
         }
     
         return $next($request);
     }
     

}
