<?php

session_start();


?>

<!DOCTYPE html>
<html>
<head>
	<title>API Cardmarket</title>

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
	<h2>Para poder utilizar los distintos menús debes iniciar sesión como administrador</h2>

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

<p>Si no tienes cuenta de administrador, puedes buscar las cartas registradas en la base de datos</p>
	

<script>
	function getApiToken(){
		var api_token = localStorage.getItem('api_token');
		document.body.innerHTML += '<h2> Tu rol es: ' + api_token + '</h2>';
	}
</script>


</body>
</html>