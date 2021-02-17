<?php
?>

<!DOCTYPE html>
<html>
<head>
	<title>Search card</title>

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
			<li><a href="http://localhost/api-cardmarket/public/add_card">Add Card to collection</a></li>
			<li><a class="selected" href="http://localhost/api-cardmarket/public/search_card">Search card</a></li>
		</ul>
	</div>

	<h1>Search Card</h1>

	<form id="formulario">
		<br>
		<p>Card</p>
		<input type="text" name="card" required id="card">

		<br>

		<input class="button" type="submit" value="Search" id="search_card">

	</form>

	<br>

	<p class="result"></p>

	<script>
         $("#search_card").click(function (e) {
		    e.preventDefault();
		    
		    $card = $('#card').val();
		    
		    var url = "http://localhost/api-cardmarket/public/api/sales/search/"+$card

		     $.ajax({
				url: url,
				type: 'GET',
				headers: {"api_token": localStorage.getItem('api_token')},
				success: function(data, status){
					console.log(data);
					//$( ".result" ).html( data );
					//if (data) {
						//for (var i = 0; i < data.length; i++) {
						//	document.write(data.values());
						//}
    			
    				//}else{
    				//	alert("Data: " + data + "\nStatus: " + status);
    				//}
    				//document.body.innerHTML += '<h2> Tu rol es: ' + api_token + '</h2>';
    				var table = '<table><tr><th>id</th><th>Card Name</th><th>Description</th><th>Collection</th></tr>';

    				for (var i in data) {
					    table += '<tr>';

					    for (var j in data[i]) {
      						table += '<td>' + data[i][j] + '</td>';
     					}

     					table += '</tr>';
					}
					table += '</table>';
					document.body.innerHTML += table;
    			}
  			})
  			
		});
      </script>

</body>
</html>