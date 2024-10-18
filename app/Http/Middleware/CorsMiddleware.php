<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse|JsonResponse
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse|JsonResponse
    {
        $response = $next($request);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'ACCEPT, CONTENT-TYPE, X-CSRF-TOKEN');
        //$response->headers->remove('X-Frame-Options',  'ALLOWALL');
        $response->headers->set('Content-Security-Policy', "frame-src 'self' http://demo321.online:8212; 
        frame-ancestors 'self' localhost/inlis-ent-2024; 
        default-src 'self' http://demo321.online:8212 https://maps.googleapis.com https://maps.gstatic.com; 
        script-src 'self' 'unsafe-inline' 'unsafe-eval' https://code.jquery.com https://cdnjs.cloudflare.com https://maps.googleapis.com; 
        style-src 'self' 'unsafe-inline' http://db.onlinewebfonts.com https://maxcdn.bootstrapcdn.com https://fonts.googleapis.com http://fonts.googleapis.com; 
        font-src 'self' http://db.onlinewebfonts.com https://maxcdn.bootstrapcdn.com https://fonts.gstatic.com http://fonts.gstatic.com; 
        img-src 'self' http://demo321.online blob: 'self' blob: https://home.perpusnas.go.id/* data: maps.gstatic.com *.googleapis.com *.ggpht");

        return $response;
    }
}