<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;
use App\Models\Collection;
use App\Models\CardCollection;

class CardController extends Controller
{
	/** POST
	 * Crear cartas con cards/create
	 *
	 * Se introduce como parámetro (petición) el name de la carta, descripción y collection
	 * a la que se va a ñadir la carta. En caso de no existir la collection se crea una nueva,
	 * en caso de existir se añade la carta a la collection. Hace falta ser admin para poder
	 * crear cartas, por lo que necesita estar logueado y enviar su token.
	 *
	 * @return response OK si se ha creado la carta 
	 */
    public function create_card(Request $request) {
    	$response = "";
    	//Leer el contenido de la petición
    	$data = $request->getContent();
    	//Decodificar el json
    	$data = json_decode($data);
    	// Buscar la collection
    	$collection = Collection::where('name', $data->collection)->get()->first();
    	// Si existe la collection
    	if($data && $collection){
    		// Crear la carta y rellenar los datos
    		$card = new Card();
    		$card->name = $data->name;
    		$card->description = $data->description;
    		
			try{
				// Guardar la carta
				$card->save();
				$response = "OK";
			}catch(\Exception $e){
				$response = $e->getMessage();
			}
			// Añadir la carta a la collection
			$cardCollection = new CardCollection();
			$cardCollection->card_id = $card->id;
			$cardCollection->collection_id = $collection->id;		
			$cardCollection->save();
		// Si no existe la collection
    	} elseif($data){
    		// Crear la carta y rellenar los datos
    		$card = new Card();
    		$card->name = $data->name;
    		$card->description = $data->description;
    		// Crear la collection y rellenar su nombre
    		$collection = new Collection();
    		$collection->name = $data->collection;
    		// Guardar la card y collection
    		try{
				$card->save();
				$collection->save();
				$response = "OK";
			}catch(\Exception $e){
				$response = $e->getMessage();
			}
			// Añadir la card a la collection
			$cardCollection = new CardCollection();
			$cardCollection->card_id = $card->id;
			$cardCollection->collection_id = $collection->id;
			$cardCollection->save();

    	} else $response = "Datos incorrectos";
    	// Enviar la respuesta
    	return $response;
    }

    /** POST
	 * Actualizar cartas con cards/update/{id}
	 *
	 * Se reciben los parametros que queremos actualizar de la card y enviamos el id de la 
	 * carta por la url. Hace falta ser admin para poder actualizar cartas, por lo
	 * que necesita estar logueado y enviar su token.
	 *
	 * @param $id id de la carta que hay que actualizar
	 * @return response OK si se ha actualizado la carta 
	 */
    public function update_card(Request $request, $id){

		$response = "";
		//Buscar la carta por su id
		$card = Card::find($id);
		// Si encuentra la carta
		if($card){
			//Leer el contenido de la petición
			$data = $request->getContent();
			//Decodificar el json
			$data = json_decode($data);
			//Si hay un json válido, buscar la carta
			if($data){
				// Actualizar elos datos de la carta
				$card->name = (isset($data->name) ? $data->name : $card->name);
				$card->description = (isset($data->description) ? $data->description : $card->description);

				try{
					// Guardar la carta actualizada en la base de datos
					$card->save();
					$response = "OK";
				}catch(\Exception $e){
					$response = $e->getMessage();
				}
			}
		}else{
			$response = "No card";
		}
		// Enviar respuesta
		return response($response);
	}

	/** POST
	 * Añadir cartas a las colecciones en card_collections_table con cards/add_card
	 *
	 * Se introduce como parámetro (petición) el id de la carta y el id de la collection a la
	 * que se va a añadir la carta. Hace falta ser admin para poder añadir cartas a las
	 * colecciones, por lo que necesita estar logueado y enviar su token.
	 *
	 * @return response OK si se ha añadido la carta a la coleccion
	 */
	public function add_card_to_collection(Request $request){

		$response = "";
		//Leer el contenido de la petición
		$data = $request->getContent();
		//Decodificar el json
		$data = json_decode($data);
		//Buscar la carta por su id
		$card = Card::find($data->card);
		// Buscar la coleccion a la que pertenece la carta por su id
		$collection = Collection::find($data->collection);
		//Si hay un json válido, existe la carta y la coleccion
		if($data && $card && $collection){
			// añadir la carta a la coleccion
			$cardCollection = new CardCollection();
			$cardCollection->card_id = $data->card;
			$cardCollection->collection_id = $data->collection;
			
			try{
				// Guardar los datos
				$cardCollection->save();
				$response = "OK";
			}catch(\Exception $e){
				$response = $e->getMessage();
			}
		} else {
			$response = "Los datos introducidos son incorrectos";
		}
		// Enviar respuesta
		return response($response);
	}
}
