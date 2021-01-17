<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class EnsureTokenIsUserOrProfessional
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
        //Leer el contenido de la petición
        $data = $request->getContent();
        //Decodificar el json
        $data = json_decode($data);
        //Si hay un json válido, comprobar el token
        if($data){
            // Buscar el usuario por el token
            $user = User::where('api_token', $data->api_token)->get()->first();
            // Si encuantra al usuario
            if($user){
                // Comprobar si su rol es usuario, o profesional
                if($user->role == 'user' || $user->role == 'professional'){
                    return $next($request);
                // Si no, enviar un error 403
                }else{
                    abort(403, "no authorized");
                } 
            }else abort(403, "el token no es correcto");
        }else abort(403, "necesitas loguear para hacer esto");
    }
}
