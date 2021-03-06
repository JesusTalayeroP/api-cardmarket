<?php
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<link rel="stylesheet" href="http://localhost/api-cardmarket/resources/css/app.css">

</head>
<body>

	<div id="bar_menu">
		<ul>
			<li><a href="http://localhost/api-cardmarket/public">Main page</a></li>
			<li><a href="http://localhost/api-cardmarket/public/signup">SignUp</a></li>
			<li><a class="selected" href="http://localhost/api-cardmarket/public/login">LogIn</a></li>
			<li><a href="http://localhost/api-cardmarket/public/create_admin">Create Admin</a></li>
			<li><a href="http://localhost/api-cardmarket/public/create_card">Create card</a></li>
			<li><a href="http://localhost/api-cardmarket/public/update_card">Update card</a></li>
			<li><a href="http://localhost/api-cardmarket/public/add_card">Add Card to collection</a></li>
			<li><a href="http://localhost/api-cardmarket/public/search_card">Search card</a></li>
		</ul>
	</div>

	<h1>LogIn</h1>

	<form id="formulario">
		<br>

		<p>Nombre de usuario</p>
		<input type="text" name="username" required id="username">

		<p>Contraseña</p>
		<input type="password" name="password" required id="password">

		<br>

		<input class="button" type="submit" value="Iniciar sesión" id="login">

	</form>

	<script>
         $("#login").click(function (e) {
		    e.preventDefault();
		    
		    $username = $('#username').val();
		    $password = $('#password').val();
		    var user = {password: $password, username: $username}

		    $.post("http://localhost/api-cardmarket/public/api/users/login", JSON.stringify(user),

		    function(data, status){
    			
    			var splitted = data.split(" ");
    			var api_token = splitted[2];
    			localStorage.setItem("api_token", api_token);

    			if (splitted[0] == "OK.") {
    				window.location.href = "http://localhost/api-cardmarket/public"
    			}else{
    				alert("Data: " + data + "\nStatus: " + status);
    			}
  			}); 
  			
		});
      </script>

</body>
</html>