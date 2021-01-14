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
			}else {
    			$response = "No puedes crear un usuario administrador";
    		}			
    	} else $response = "Datos incorrectos";

    	return $response;
    }


    public function signup_admin(Request $request) {
    	$response = "";

    	$data = $request->getContent();

    	$data = json_decode($data);

    	if($data){
    		$user = new User();

    		$user->username = $data->username;
    		$user->email = $data->email;
    		$user->password = Hash::make($data->password);
    		$user->role = 'admin';

    		try{
    			$user->save();
				$response = "OK";
			}catch(\Exception $e){
				$response = $e->getMessage();
			}			
    	} else $response = "Datos incorrectos";

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
}	
