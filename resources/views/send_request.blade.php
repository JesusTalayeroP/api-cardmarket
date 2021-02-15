<?php
 
 echo("esta entrando");
	
$data = [
	'username' => username,
	'password' => password,
]; 

$json = json_encode($data);

$response = Http::post('http://localhost:8888/api-cardmarket/public/api/users/login', $json);

echo($response);

