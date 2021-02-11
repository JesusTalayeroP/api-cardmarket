//require('./bootstrap');
	
var formulario = document.getElementById('formulario');

formulario.addEventListener('submit', function(e){

	e.preventDefault();
	var formData = new FormData(this);
	var jsonData = {};

	for(var [k, v] of formData) {
		jsonData[k] = v;
	}

console.log(jsonData);
	
fetch('post.php',{
	method: 'POST',
	body: jsonData
})
	.then( res => res.jsonData())
	.then(da)
	
});