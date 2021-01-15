<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\CardCollection;
use App\Models\Card;

class CollectionController extends Controller
{
    public function create_collection(Request $request) {
    	$response = "";

    	$data = $request->getContent();

    	$data = json_decode($data);
    	
    	$card = Card::where('name', $data->card)->get()->first();

    	if($data && $card){

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

			$cardCollection = new CardCollection();
			$cardCollection->card_id = $card->id;
			$cardCollection->collection_id = $collection->id;		
			$cardCollection->save();

    	} elseif($data){

    		$collection = new Collection();
    		$collection->name = $data->name;
    		$collection->icon = $data->icon;
    		$collection->release_date = $data->release_date;

    		$card = new Card();
    		$card->name = $data->card;

    		try{
				$card->save();
				$card_id = $card->id;
				$collection->save();
				$collection_id = $collection->id;
				$response = "OK";
			}catch(\Exception $e){
				$response = $e->getMessage();
			}

			$cardCollection = new CardCollection();
			$cardCollection->card_id = $card->id;
			$cardCollection->collection_id = $collection->id;
			$cardCollection->save();

    	} else $response = "Datos incorrectos";

    	return $response;
    }

    public function update_collection(Request $request, $id){

		$response = "";

		//Buscar el equipo por su id
		$collection = Collection::find($id);
		// Si encuentra el equipo
		if($collection){

			//Leer el contenido de la petición
			$data = $request->getContent();

			//Decodificar el json
			$data = json_decode($data);

			//Si hay un json válido, buscar el equipo
			if($data){
			
				// Actualizar el nombre del equipo
				$collection->name = (isset($data->name) ? $data->name : $collection->name);
				$collection->icon = (isset($data->icon) ? $data->icon : $collection->icon);
				$collection->release_date = (isset($data->release_date) ? $data->release_date : $collection->release_date);

				try{
					// Guardar el equipo actualizado en la base de datos
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
