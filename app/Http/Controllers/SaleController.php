<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Card;
use App\Models\CardCollection;
use App\Models\Collection;
use App\Models\User;

use App\Http\Helpers\MyJWT;
use \Firebase\JWT\JWT;

class SaleController extends Controller
{
	/** GET
	 * Buscar cartas con sales/search/{card_name}
	 *
	 * Se introduce por url el nombre de la carta que queremos buscar, y enviamos en la request
	 * el token del usuario. Hace falta ser usuario o profesional para poder buscar cartas,
	 * por lo que necesita estar logueado y enviar su token. 
	 *
	 * @return response las cartas encontradas
	 */
    public function search_card(Request $request, $card_name){
    	$response = "";

        $key = MyJWT::getKey();
        //Decodificar el token
        $headers = getallheaders();
        //$decoded = JWT::decode($headers['api_token'], $key, array('HS256'));

    	// Buscar todas las cartas que pertenecen a una collection
    	$cardsCollection = CardCollection::all();

    	$response = [];
		// Si hay cartas registradas
    	if($cardsCollection){
            //echo("ha encontrado todas cartas que pertenecen a una colección \n");
    		// Recorrer cada una de las cartas para comprobar sus datos 
    		for ($i=0; $i < count($cardsCollection); $i++) { 
    			// Buscar la carta para acceder a sus datos
    			$card = Card::find($cardsCollection[$i]->card_id);
                //echo("busca las cartas sin colección \n");
    			// Si el nombre de la carta coincide con el que busca el usuario
    			if(strcasecmp($card->name, $card_name) == 0){
    				// Buscamos la collection para acceder a sus datos
    				$collection = Collection::find($cardsCollection[$i]->collection_id);
                    //echo("Busca la carta introducida por el usuario \n");
    				// Guardamos la carta para mostrarsela al usuario
    				$response [] = [
    				"id" => $cardsCollection[$i]->id,
    				"name" => $card->name,
    				"description" => $card->description,
    				"collection" => $collection->name
    				];
    			}
    		}
    	} 
    	// Si no encuantra ninguna carta coincidente
    	if($response == []){
    		$response = "No se encontraron cartas con ese nombre";
            //echo("no ha encontrado ninguna carta \n");
    	}
    	// Enviar la respuesta
    	return $response;
    }

	/** POST
	 * Poner a la venta una carta con sales/create
	 *
	 * Se introduce como parámetro (petición) el id de la carta que se va a vender, la cantidad
	 * que desa poner a la venta y el precio total. Hace falta ser usuario o profesional para poder 
	 * vender cartas, por lo que necesita estar logueado y enviar su token. 
	 *
	 * @return response OK si se pone la carta a la venta
	 */
    public function create_sale(Request $request) {
    	$response = "";
    	//Leer el contenido de la petición
    	$data = $request->getContent();
    	//Decodificar el json
    	$data = json_decode($data);

        $key = MyJWT::getKey();
        //Decodificar el token
        $headers = getallheaders();
        $decoded = JWT::decode($headers['api_token'], $key, array('HS256'));

    	//Si hay un json válido, crear la venta
    	if($data){
    		$sale = new Sale();
    		// Rellenar los datos de la venta
    		$sale->quantity = $data->quantity;
    		$sale->price = $data->price;
    		$sale->card_collection_id = $data->card_id;
    		$sale->user_id = $decoded->id;

			try{
				$sale->save();
				$response = "OK";
			}catch(\Exception $e){
				$response = $e->getMessage();
			}
    	} else $response = "No data";
    	// Enviar respuesta
    	return $response;
    }

	/** GET
	 * Buscar una carta a la venta con sales/buy/{card_name}
	 *
	 * Se introduce por url el nombre de la carta que se quiere comprar para comprobar si hay a la venta 
	 *
	 * @return response las cartas que se encuentran a la venta
	 */
    public function buy_card(Request $request, $card_name){
    	$response = "";
    	// Ordenar las ventas por precio
    	$sales = Sale::orderBy('price', 'ASC')->get();

    	$response = [];
		// Si se encuentran cartas a la venta
    	if($sales){
    		// Recorrer todas las cartas a la venta para comprobar su datos individualmente
    		for ($i=0; $i < count($sales); $i++) { 
    			// Buscar la carta que esta a la venta
    			$cardCollection = CardCollection::where('id', $sales[$i]->card_collection_id)->get()->first();
    			// Comprobar los datos de la carta que esta a la venta
				$card = Card::find($cardCollection->card_id);
    			// Si coincide su nombre con el que ha buscado el usuario
    			if(strcasecmp($card->name, $card_name) == 0){
    				// Comprobamos los datos de la collection a la que pertenece
    				$collection = Collection::find($cardCollection->collection_id);
    				//Comprobamos que usuario la ha puesto a al venta
    				$user = User::find($sales[$i]->user_id);
    				// Guardamos los datos de la carta para mostrarlas
    				$response [] = [
    				"name" => $card->name,
    				"description" => $card->description,
    				"collection" => $collection->name,
    				"quantity" => $sales[$i]->quantity,
    				"price" => $sales[$i]->price,
    				"seller" => $user->username
    				];
    			}
    		}

    	} 
    	// Si no se encuantra ninguna carta
    	if($response == []){
    		$response = "No se encontraron cartas con ese nombre";
    	}
    	// Enviar la respuesta
    	return $response;
    }
}
