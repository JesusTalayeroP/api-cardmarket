<?php


?>


<!DOCTYPE html>
<html>
<head>
	<title>main page</title>

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
	<h1>Has logueado correctamente</h1>

	

	<div id="bar_menu">
		<ul>
			<li><a href="http://localhost/api-cardmarket/public/main">Main page</a></li>
			<li><a href="http://localhost/api-cardmarket/public/signup">SignUp</a></li>
			<li><a href="http://localhost/api-cardmarket/public/login">LogIn</a></li>
			<li><a href="http://localhost/api-cardmarket/public/create_admin">Create Admin</a></li>
			<li><a href="http://localhost/api-cardmarket/public/create_card">Create card</a></li>
			<li><a href="http://localhost/api-cardmarket/public/update_card">Update card</a></li>
			<li><a href="http://localhost/api-cardmarket/public/add_card">Add Card to collection</a></li>
			<li><a href="http://localhost/api-cardmarket/public/create_collection">Create collection</a></li>
			<li><a href="http://localhost/api-cardmarket/public/update_collection">Update collection</a></li>
			<li><a href="http://localhost/api-cardmarket/public/search_card">Search card</a></li>
		</ul>
	</div>

	<input type="button" onclick="getApiToken()" value="mostrar token">

<script>
	function getApiToken(){
		var api_token = localStorage.getItem(api_token);
		document.body.innerHTML += '<h2> Tu rol es: ' + api_token + '</h2>';
	}
</script>

</body>
</html>