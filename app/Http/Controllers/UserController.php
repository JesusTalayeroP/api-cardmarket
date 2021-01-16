<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function signup_user(Request $request) {
    	$response = "";

    	$data = $request->getContent();

    	$data = json_decode($data);

    	if($data){
    		$user = new User();

    		$user->username = $data->username;
    		$user->email = $data->email;
    		$user->password = Hash::make($data->password);

    		if($data->role === "user" || $data->role === "professional"){
    			$user->role = $data->role;
    			try{
    				$user->save();
					$response = "OK";
				}catch(\Exception $e){
					$response = $e->getMessage();
    			}
                if($user->id == 1){
                    $user->role = "admin";
                    $user->save();
                }
			}else {
    			$response = "No puedes crear un usuario administrador";
    		}			
    	} else $response = "Datos incorrectos";

    	return $response;
    }


    public function create_admin(Request $request, $id) {
    	$response = "";

    	$user = User::find($id);

    	if($user){

    		$user->role = 'admin';

    		try{
    			$user->save();
				$response = "OK";
			}catch(\Exception $e){
				$response = $e->getMessage();
			}			
    	} else $response = "Usuario no encontrado";

    	return $response;
    }

    public function login_user(Request $request) {
    	$response = "";

    	$data = $request->getContent();

    	$data = json_decode($data);

    	$user = User::where('username', $data->username)->get()->first();

    	if($user && Hash::check($data->password, $user->password)){

			$token = Str::random(60);
			$user->api_token = $token;

			try{
    			$user->save();
				$response = "OK";
			}catch(\Exception $e){
				$response = $e->getMessage();
			}
    		
    	}else $response = "El usuario o la contraseña son incorrectos";

    	return $response;
	}

	public function reset_password(Request $request) {
		$response = "";

    	$data = $request->getContent();

    	$data = json_decode($data);

    	$user = User::where('email', $data->email)->get()->first();

    	if($user){
    		$new_password = Str::random(15);

    		$user->password = Hash::make($new_password);

    		 try{
    			$user->save();
				$response = "Tu nueva contraseña es: ".$new_password;
			}catch(\Exception $e){
				$response = $e->getMessage();
			}
    	}else $response = "El usuario introducido no existe";

    	return $response;
	}
}	
