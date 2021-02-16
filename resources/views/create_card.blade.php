<?php

?>

<!DOCTYPE html>
<html>
<head>
	<title>Crear Carta</title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<link rel="stylesheet" href="http://localhost/api-cardmarket/resources/css/app.css">

</head>
<body>
	<div id="bar_menu">
		<ul>
			<li><a href="http://localhost/api-cardmarket/public">Main page</a></li>
			<li><a href="http://localhost/api-cardmarket/public/signup">SignUp</a></li>
			<li><a href="http://localhost/api-cardmarket/public/login">LogIn</a></li>
			<li><a href="http://localhost/api-cardmarket/public/create_admin">Create Admin</a></li>
			<li><a class="selected" href="http://localhost/api-cardmarket/public/create_card">Create card</a></li>
			<li><a href="http://localhost/api-cardmarket/public/update_card">Update card</a></li>
			<li><a href="http://localhost/api-cardmarket/public/add_card">Add Card to collection</a></li>
			<li><a href="http://localhost/api-cardmarket/public/search_card">Search card</a></li>
		</ul>
	</div>

	<h1>Sign Up</h1>

	<form id="formulario">
		<br>
		<p>Nombre</p>
		<input type="text" name="name" required id="name">

		<p>Descripción</p>
		<input type="text" name="description" required id="description">

		<p>Collección</p>
		<input type="text" name="collection" required id="collection">

		</select>

		<br>

		<input class="button" type="submit" value="Crear carta" id="create_card">

	</form>

		<script>
         $("#create_card").click(function (e) {
		    e.preventDefault();
		    
		    $name = $('#name').val();
		    $description = $('#description').val();
		    $collection = $('#collection').val();

		    $url = "http://localhost/api-cardmarket/public/api/cards/create"

		    var card = {name: $name, description: $description, collection: $collection}

		    $.ajax({
				url: $url,
				type: 'POST',
				headers: {"api_token": localStorage.getItem('api_token')},
				data: JSON.stringify(card),
				success: function(data, status){
					console.log(data);
					if (data == "OK") {
    					alert("Carta creada correcta correctamente" + "\nStatus: " + status);
    				}else{
    					alert("Data: " + data + "\nStatus: " + status);
    				}
    			}
  			})

		});
  			
      </script>

</body>
</html>