<?php
?>

<!DOCTYPE html>
<html>
<head>
	<title>Create admin</title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<link rel="stylesheet" href="http://localhost/api-cardmarket/resources/css/app.css">

</head>
<body>
	<div id="bar_menu">
			<ul>
				<li><a href="http://localhost/api-cardmarket/public">Main page</a></li>
				<li><a href="http://localhost/api-cardmarket/public/signup">SignUp</a></li>
				<li><a href="http://localhost/api-cardmarket/public/login">LogIn</a></li>
				<li><a class="selected" href="http://localhost/api-cardmarket/public/create_admin">Create Admin</a></li>
				<li><a href="http://localhost/api-cardmarket/public/create_card">Create card</a></li>
				<li><a href="http://localhost/api-cardmarket/public/update_card">Update card</a></li>
				<li><a href="http://localhost/api-cardmarket/public/add_card">Add Card to collection</a></li>
				<li><a href="http://localhost/api-cardmarket/public/search_card">Search card</a></li>
			</ul>
	</div>	

	<h2>Introduce el id de un usuario para hacerle administrador</h2>

	<form id="formulario">
		<br>

		<p>Id usuario</p>
		<input type="text" name="user_id" required id="user_id">

		<br>

		<input class="button" type="submit" value="Hacer Admin" id="create_admin">

	</form>

	<script>
         $("#create_admin").click(function (e) {
		    e.preventDefault();
		    
		    $id = $('#user_id').val();
		    $url = "http://localhost/api-cardmarket/public/api/users/create_admin/"+$id
		    
		    $.ajax({
				url: $url,
				type: 'POST',
				headers: {"api_token": localStorage.getItem('api_token')},
				data: []	,
				success: function(data, status){
					if(data == "OK"){
						alert("Admin creado correctamente \nStatus: " + status);
					} else {
						alert("Data: " + data + "\nStatus: " + status);
					}
    			}
  			})
		});
  			
      </script>



</body>
</html>