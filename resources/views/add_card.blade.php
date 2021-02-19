<?php

?>

<!DOCTYPE html>
<html>
<head>
	<title>Añadir Carta a colección</title>

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
			<li><a href="http://localhost/api-cardmarket/public/create_card">Create card</a></li>
			<li><a href="http://localhost/api-cardmarket/public/update_card">Update card</a></li>
			<li><a class="selected" href="http://localhost/api-cardmarket/public/add_card">Add Card to collection</a></li>
			<li><a href="http://localhost/api-cardmarket/public/search_card">Search card</a></li>
		</ul>
	</div>

	<h1>Add Card to Collection</h1>

	<form id="formulario">
		<br>
		<p>Id de la carta</p>
		<input type="text" name="card_id" required id="card_id">
		<br>
		<p>Id de la colleción</p>
		<input type="text" name="collection_id" required id="collection_id">

		<br>

		<input class="button" type="submit" value="Añadir carta" id="add_card">

	</form>

		<script>
         $("#add_card").click(function (e) {
		    e.preventDefault();
		    
		    $card_id = $('#card_id').val();
		    $collection_id = $('#collection_id').val();
		    
		    $url = "http://localhost/api-cardmarket/public/api/cards/add_card"

		    var data = {card: $card_id, collection: $collection_id}

		    $.ajax({
				url: $url,
				type: 'POST',
				headers: {"api_token": localStorage.getItem('api_token')},
				data: JSON.stringify(data),
				success: function(data, status){
					console.log(data);
					if (data == "OK") {
    					alert("Carta añadida correctamente" + "\nStatus: " + status);
    				}else{
    					alert("Data: " + data + "\nStatus: " + status);
    				}
    			}
  			})

		});
  			
      </script>

</body>
</html>