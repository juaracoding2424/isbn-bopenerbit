<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PenerbitMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //\Log::info(session('penerbit')['STATUS']);
        if (session('penerbit') == null) {
            return redirect('/login');
        }
        /*if(session('penerbit')['STATUS'] == 'valid') {
            return redirect('penerbit/dashboard/notvalid');
        } */
        return $next($request);
    }
}
