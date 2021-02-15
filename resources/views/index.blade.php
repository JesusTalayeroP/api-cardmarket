<?php

session_start();


?>

<!DOCTYPE html>
<html>
<head>
	<title>API Cardmarket</title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>

	<h1>Bienvenido a la API de Card Market</h1>
	<h2>Debes iniciar sesión para continuar</h2>

	<form id="formulario">
		<p>Nombre de usuario</p>
		<input type="name" name="username" required id="username">

		<p>Contraseña</p>
		<input type="password" name="password" required id="password">

		<input type="submit" value="Iniciar sesión" id="login">

	</form>

	<script>
         $("#login").click(function (e) {
		    e.preventDefault();
		    
		    $username = $('#username').val();
		    $password = $('#password').val();
		    var user = {password: $password, username: $username}
		    //console.log($username);
		    //console.log($password);

		    $.post("http://localhost/api-cardmarket/public/api/users/login", JSON.stringify(user),

		    function(data, status){
    			
    			var splitted = data.split(" ");
    			var api_token = splitted[2];
    			localStorage[api_token] = api_token;
    			
    			if (splitted[0] == "OK.") {
    				window.location.href = "http://localhost/api-cardmarket/public/main"
    			}else{
    				alert("Data: " + data + "\nStatus: " + status);
    			}
  			}); 
		});
      </script>


</body>
</html>