<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\CardCollection;
use App\Models\Card;

use App\Http\Helpers\MyJWT;
use \Firebase\JWT\JWT;

class CollectionController extends Controller
{
	/** POST
	 * Crear collections con collections/create
	 *
	 * Se introduce como parámetro (petición) el name de la collection, icon, release_date y
	 * card que se va a añadir a la collection. En caso de no existir la card se crea una nueva,
	 * en caso de existir se añade la carta a la collection. Hace falta ser admin para poder
	 * crear collections, por lo que necesita estar logueado y enviar su token.
	 *
	 * @return response OK si se ha creado la collection 
	 */
    public function create_collection(Request $request) {
    	$response = "";
    	//Leer el contenido de la petición
    	$data = $request->getContent();
    	//Decodificar el json
    	$data = json_decode($data);

    	$key = MyJWT::getKey();
        //Decodificar el token
        $headers = getallheaders();
        $decoded = JWT::decode($headers['api_token'], $key, array('HS256'));
    	// Buscar la carta por su nombre
    	$card = Card::where('name', $data->card)->get()->first();
    	// Si existe la carta
    	if($data && $card){
    		// Crear la collection y rellenar sus datos
    		$collection = new Collection();
    		$collection->name = $data->name;
    		$collection->icon = $data->icon;
    		$collection->release_date = $data->release_date;
    		
			try{
				$collection->save();
				$response = "OK";
			}catch(\Exception $e){
				$response = $e->getMessage();
			}
			// Añadir la carta a la collection creada
			$cardCollection = new CardCollection();
			$cardCollection->card_id = $card->id;
			$cardCollection->collection_id = $collection->id;		
			$cardCollection->save();
		// Si no existe la carta
    	} elseif($data){
    		// Crear la collection nueva
    		$collection = new Collection();
    		$collection->name = $data->name;
    		$collection->icon = $data->icon;
    		$collection->release_date = $data->release_date;
    		// Crear la carta nueva
    		$card = new Card();
    		$card->name = $data->card;
    		// Guardar los datos
    		try{
				$card->save();
				$collection->save();
				$response = "OK";
			}catch(\Exception $e){
				$response = $e->getMessage();
			}
			// Añadir la carta a la collection
			$cardCollection = new CardCollection();
			$cardCollection->card_id = $card->id;
			$cardCollection->collection_id = $collection->id;
			$cardCollection->save();

    	} else $response = "Datos incorrectos";
    	// Enviar la respuesta
    	return $response;
    }

	/** POST
	 * Actualizar collections con collections/update/{id}
	 *
	 * Se reciben los parametros que queremos actualizar de la collection y enviamos el id de la 
	 * misma por la url. Hace falta ser admin para poder actualizar collections, por lo
	 * que necesita estar logueado y enviar su token.
	 *
	 * @param $id id de la collection que hay que actualizar
	 * @return response OK si se ha actualizado la collection 
	 */
    public function update_collection(Request $request, $id){

		$response = "";
		
		$key = MyJWT::getKey();
        //Decodificar el token
        $headers = getallheaders();
        $decoded = JWT::decode($headers['api_token'], $key, array('HS256'));

		//Buscar la collection por su id
		$collection = Collection::find($id);
		// Si encuentra la collection
		if($collection){
			//Leer el contenido de la petición
			$data = $request->getContent();
			//Decodificar el json
			$data = json_decode($data);
			//Si hay un json válido, buscar la collection
			if($data){
				// Actualizar los datos de la collection
				$collection->name = (isset($data->name) ? $data->name : $collection->name);
				$collection->icon = (isset($data->icon) ? $data->icon : $collection->icon);
				$collection->release_date = (isset($data->release_date) ? $data->release_date : $collection->release_date);

				try{
					// Guardar la collection actualizada en la base de datos
					$collection->save();
					$response = "OK";
				}catch(\Exception $e){
					$response = $e->getMessage();
				}
			} else $response = "Datos incorrectos";
		} else $response = "No collection";
		
		// Enviar respuesta
		return response($response);
	}
}
