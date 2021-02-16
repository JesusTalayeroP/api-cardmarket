<?php


?>


<!DOCTYPE html>
<html>
<head>
	<title>main page</title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<link rel="stylesheet" href="http://localhost/api-cardmarket/resources/css/app.css">

</head>
<body>
	
	<h1>Card Market Web Client</h1>
	

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

	<h1>Has logueado correctamente</h1>

	

<script>
	function getApiToken(){
		var api_token = localStorage.getItem('api_token');
		document.body.innerHTML += '<h2> Tu rol es: ' + api_token + '</h2>';
	}
</script>

</body>
</html>