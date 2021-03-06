<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

use \Firebase\JWT\JWT;
use App\Http\Helpers\MyJWT;

use Firebase\Auth\Token\Exception\InvalidToken;

class EnsureTokenIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $key = MyJWT::getKey();

        $headers = getallheaders();

        if(isset($headers['api_token'])){
            if($headers['api_token'] != ""){

                $decoded = JWT::decode($headers['api_token'], $key, array('HS256')); 

                if($decoded){  
                    
                    // Comprobar si su rol es admin
                    if($decoded->role == 'admin'){
                        return $next($request);
                    // Si no, enviar un error 403    
                        
                    }else abort(403, "no authorized");
                }else abort(403, "Token incorrecto");
            }else abort(403, "El token está vacío");   
        }else abort(403, "No hay token");
    }
}
