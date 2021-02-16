<?php
?>

<!DOCTYPE html>
<html>
<head>
	<title>Signup</title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<link rel="stylesheet" href="http://localhost/api-cardmarket/resources/css/app.css">

</head>
<body>
	<h1>Sign Up</h1>

	<div id="bar_menu">
		<ul>
			<li><a href="http://localhost/api-cardmarket/public">Main page</a></li>
			<li class="selected"><a href="http://localhost/api-cardmarket/public/signup">SignUp</a></li>
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
		<p>Email</p>
		<input type="Email" name="email" required id="email">

		<p>Nombre de usuario</p>
		<input type="name" name="username" required id="username">

		<p>Contraseña</p>
		<input type="password" name="password" required id="password">

		<p>Confirmar contraseña</p>
		<input type="password" name="confirm_password" required id="confirm_password">

		<p>Rol</p>
		<select name="role" required id="role">

		<option>user</option>

		<option>professional</option>

		</select>

		<br>

		<input type="submit" value="Registrarse" id="signup">

	</form>

	<script>
         $("#signup").click(function (e) {
		    e.preventDefault();
		    
		    $username = $('#username').val();
		    $email = $('#email').val();
		    if ($('#password').val() == $('#confirm_password').val()){
		    	$password = $('#password').val();
		    }else {
		    	alert("Las contraseñas no coinciden");
		    	throw new Error("Las contraseñas no coinciden");
		    }
		    $role = document.getElementById("role").value;
		    
		    var user = {username: $username, email: $email, password: $password, role: $role}
		    //console.log($username);
		    //console.log($password);
		    //console.log($email);
		    console.log($role);

		    $.post("http://localhost/api-cardmarket/public/api/users/signup", JSON.stringify(user),

		    function(data, status){

    			if (data == "OK") {
    				alert("Usuario registrado");
    				window.location.href = "http://localhost/api-cardmarket/public/login"
    			}else{
    				alert("Data: " + data + "\nStatus: " + status);
    			}
  			}); 
  			
		});
      </script>

</body>
</html>