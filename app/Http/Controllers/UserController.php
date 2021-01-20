<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Http\Helpers\MyJWT;
use \Firebase\JWT\JWT;

class UserController extends Controller
{
    /** POST
     * Crear un nuevo usuario con users/signup
     *
     * Se introduce como parámetro (petición) el username, email, password y role
     * del usuario, el primer usuario que se cree en la bbdd será administrador
     * para poder gestionar el resto de funciones de la api
     *
     * @return response OK si se ha creado el usuario 
     */
    public function signup_user(Request $request) {
    	$response = "";
        //Leer el contenido de la petición
    	$data = $request->getContent();
        //Decodificar el json
    	$data = json_decode($data);
        //Si hay un json válido, crear el usuario   
    	if($data){
    		$user = new User();
            //Rellenar los campos
    		$user->username = $data->username;
    		$user->email = $data->email;
    		$user->password = Hash::make($data->password);
            // Si el rol es user o professional se completa el registro
    		if($data->role === "user" || $data->role === "professional"){
    			$user->role = $data->role;
    			try{
    				$user->save();
					$response = "OK";
				}catch(\Exception $e){
					$response = $e->getMessage();
    			}
                // Si es el primer usuario creado se le da el rol de admin
                if($user->id == 1){
                    $user->role = "admin";
                    $user->save();
                }
			}else {
    			$response = "No puedes crear un usuario administrador";
    		}			
    	} else $response = "Datos incorrectos";
        //Enviar la respuesta
    	return $response;
    }

    /** POST
     * Cambiar el rol de un usuario cualquiera a admin con users/create_admin/{id}
     *
     * Se recibe el id del usuario que queremos actualizar a administrador. Esto solo 
     * puede hacerlo un administrador, tiene que estar logueado para poder recibir su token
     *
     * @param $id id del usuario que va a ser admin
     * @return response OK si se ha cambiado el role correctamente 
     */
    public function create_admin(Request $request, $id) {
    	$response = "";

        $key = MyJWT::getKey();
        //Decodificar el token
        $headers = getallheaders();
        $decoded = JWT::decode($headers['api_token'], $key, array('HS256'));

        // Buscar el usuario por id
    	$user = User::find($id);
        // Si lo encuentra
    	if($user){
            // Cambiamos su role a admin
    		$user->role = 'admin';

    		try{
    			$user->save();
				$response = "OK";
			}catch(\Exception $e){
				$response = $e->getMessage();
			}			
    	} else $response = "Usuario no encontrado";
        // Enviar la respuesta
    	return $response;
    }

    /** POST
     * Loguear un usuario con users/login
     *
     * Se introduce como parámetro (petición) el username y password del usuario
     * que quiere loguear, se crea su token para poder tener acceso a las distintas 
     * funciones de la api
     *
     * @return response OK si se ha logueado el usuario 
     */
    public function login_user(Request $request) {
    	$response = "";
        //Leer el contenido de la petición
    	$data = $request->getContent();
        //Decodificar el json
    	$data = json_decode($data);
        // Buscar el usuario por su username
    	$user = User::where('username', $data->username)->get()->first();

        $payload = MyJWT::generatePayload($user);
        $key = MyJWT::getKey();

        $jwt = JWT::encode($payload, $key);

        // Si existe y la contraseña coincide
    	if($user && Hash::check($data->password, $user->password)){
            // Crear un token aleatorio y guardarlo
			$user->api_token = $jwt;

			try{
    			$user->save();
				$response = "OK. Token: ".$jwt;
			}catch(\Exception $e){
				$response = $e->getMessage();
			}
    		
    	}else $response = "El usuario o la contraseña son incorrectos";
        // Enviar la respuesta
    	return $response;
	}

    /** POST
     * Restablecer una contraseña con users/reset_password
     *
     * Se introduce como parámetro (petición) el email del usuario que quiere 
     * restablecer su contraseña. Se le muestra la nueva contraseña para que 
     * pueda guardarla e iniciar sesion
     *
     * @return response OK si se ha logueado el usuario 
     */
	public function reset_password(Request $request) {
		$response = "";
        //Leer el contenido de la petición
    	$data = $request->getContent();
        //Decodificar el json
    	$data = json_decode($data);
        // Buscar el usuario por su email
    	$user = User::where('email', $data->email)->get()->first();
        // Si se encuentra el usuario
    	if($user){
            // Generar una nueva contraseña aleatoria
    		$new_password = Str::random(15);
            // Guardar la contraseña en la bbdd
    		$user->password = Hash::make($new_password);

    		 try{
    			$user->save();
                // Se envia la nueva contraseña al usuario
				$response = "Tu nueva contraseña es: ".$new_password;
			}catch(\Exception $e){
				$response = $e->getMessage();
			}
    	}else $response = "El usuario introducido no existe";
        // Enviar la respuesta
    	return $response;
	}
}	
