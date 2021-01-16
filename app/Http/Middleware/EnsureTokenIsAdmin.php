<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

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

        $data = $request->getContent();

        $data = json_decode($data);

        if($data){

            $user = User::where('api_token', $data->api_token)->get()->first();

            if($user){
                if($user->role == 'admin'){

                    return $next($request);

                }else{
                    abort(403, "no authorized");
                } 
            }else abort(403, "el token no es correcto");
        }else abort(403, "necesitas loguear para hacer esto");

        
    }
}
