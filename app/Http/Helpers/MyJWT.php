<?php

namespace App\Http\Helpers;
use \Firebase\JWT\JWT;

class MyJWT{

    private const KEY = 'gvb$ijpdsipuvbu89ewbf&&gi9qw8f0gv8efbh9wncVAHNS89FVB&ENW9ucv9DSBCN9bhwc9q&$wbv9buew';
    
    public static function generatePayload($user){
        $payload = array(            
            'role' => $user->role,
            'id' => $user->id
        );

        return $payload;
    }

    public static function getKey(){
        return self::KEY;
    }

    /*public static function generateToken($username){
        return JWT::encode(generatePayload($username), self::KEY);
    }*/
}