<?php
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<style>
		*{
			max-width: 1200px;
			margin-left: 0px !important
		}
		
		#bar_menu{
			background-color: gray;
			height: 34px
		}
		ul{
			
			display: inline;
			list-style-type: none;
  			margin: 0px;
  			padding: 0px;

		}
		li{
			float: left;
		}
		a{
			display: block;
  			padding: 8px;
			text-decoration: none;
			color: orange;
		}

		a:hover{
			background-color: lavender;
		}



	</style>
</head>
<body>
	<h1>Bienvenido a la API de Card Market</h1>
	<h2>Debes iniciar sesión para continuar</h2>

	<div id="bar_menu">
		<ul>
			<li><a href="http://localhost/api-cardmarket/public">Main page</a></li>
			<li><a href="http://localhost/api-cardmarket/public/signup">SignUp</a></li>
			<li><a href="http://localhost/api-cardmarket/public/login">LogIn</a></li>
			<li><a href="http://localhost/api-cardmarket/public/create_admin">Create Admin</a></li>
			<li><a href="http://localhost/api-cardmarket/public/create_card">Create card</a></li>
			<li><a href="http://localhost/api-cardmarket/public/update_card">Update card</a></li>
			<li><a href="http://localhost/api-cardmarket/public/add_card">Add Card to collection</a></li>
			<li><a href="http://localhost/api-cardmarket/public/search_card">Search card</a></li>
		</ul>
	</div>

	<form id="formulario">
		<br>
		<p>Nombre de usuario</p>
		<input type="name" name="username" required id="username">

		<p>Contraseña</p>
		<input type="password" name="password" required id="password">

		<br>

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