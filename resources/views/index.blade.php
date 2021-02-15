<?php



?>

<!DOCTYPE html>
<html>
<head>
	<title>API Cardmarket</title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>

	<h1>Bienvenido a la API de Card Market</h1>
	<h2>Debes iniciar sesión para loguear</h2>

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

		    $.post("http://localhost:8888/api-cardmarket/public/api/users/login", JSON.stringify(user),

		    function(data, status){
    			alert("Data: " + data + "\nStatus: " + status);
    			console.log(data);
  			}); 
		});
      </script>


</body>
</html>