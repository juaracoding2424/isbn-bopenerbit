<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\AuthApi;

class JWTValidation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $authorization = $request->bearerToken();
        if(!$authorization){
            return response()->json([
                'message'   => 'Token is required!',
                'status'    => 'Failed'
            ], 401);
        }
        //\Log::info($authorization);
        //\Log::info(urlencode("SELECT * FROM PENERBIT WHERE JWT='$authorization'"));
        $authapi = kurl("get","getlistraw", "", "SELECT * FROM PENERBIT WHERE JWT='$authorization'", 'sql', '')["Data"]["Items"];
        //\Log::info($authapi);

        if(!isset($authapi[0])){
            return response()->json([
                'message'   => 'Token not valid!',
                'status'    => 'Failed'
            ], 401);
        } 
        if($authorization != $authapi[0]['JWT']){
            //\Log::info("func 2");
            return response()->json([
                'message'   => 'Token not valid.',
                'status'    => 'Failed'
            ], 401);
        } 
        if($authapi[0]['JWT'] == '123ABC-demoonly' && $request->ip() != '127.0.0.1'){
            return response()->json([
                'message'   => 'Application Key for demo only.',
                'status'    => 'Failed'
            ], 401);
        } 
        if($authapi[0]['IS_API_ENABLE'] == '0 '&& $authapi->jwt != '123ABC-demoonly'){
            return response()->json([
                'message'   => 'Application Key is disabled. Contact administrator.',
                'status'    => 'Failed'
            ], 401);
        } 
        if((strtotime(date('Y-m-d H:i:s')) > strtotime($authapi[0]["JWT_EXPIRED"])) && $authapi[0]['JWT'] != '123ABC-demoonly'){
            return response()->json([
                'message'   => 'Token expired. Please request new token',
                'status'    => 'Failed'
            ], 401);
        }

        return $next($request);
    }
}
