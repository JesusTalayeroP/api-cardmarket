<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;
use App\Models\Collection;
use App\Models\CardCollection;

class CardController extends Controller
{
    public function create_card(Request $request) {
    	$response = "";

    	$data = $request->getContent();

    	$data = json_decode($data);

    	
    	$collection = Collection::where('name', $data->collection)->get()->first();
    	

    	if($data && $collection){

    		$card = new Card();
    		$card->name = $data->name;
    		$card->description = $data->description;
    		
			try{
				$card->save();
				$card_id = $card->id;
				$response = "OK";
			}catch(\Exception $e){
				$response = $e->getMessage();
			}

			$cardCollection = new CardCollection();
			$cardCollection->card_id = $card->id;
			$cardCollection->collection_id = $collection->id;		
			$cardCollection->save();

    	} elseif($data){

    		$card = new Card();
    		$card->name = $data->name;
    		$card->description = $data->description;

    		$collection = new Collection();
    		$collection->name = $data->collection;

    		try{
				$card->save();
				$collection->save();
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


    public function update_card(Request $request, $id){

		$response = "";

		//Buscar el equipo por su id
		$card = Card::find($id);
		// Si encuentra el equipo
		if($card){

			//Leer el contenido de la petición
			$data = $request->getContent();

			//Decodificar el json
			$data = json_decode($data);

			//Si hay un json válido, buscar el equipo
			if($data){
			
				// Actualizar el nombre del equipo
				$card->name = (isset($data->name) ? $data->name : $card->name);
				$card->description = (isset($data->description) ? $data->description : $card->description);

				try{
					// Guardar el equipo actualizado en la base de datos
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


	public function add_card_to_collection(Request $request){

		$response = "";
		//Leer el contenido de la petición
		$data = $request->getContent();

		//Decodificar el json
		$data = json_decode($data);

		//Buscar el equipo por su id
		$card = Card::find($data->card);
		// Buscar el soldado que lidera el equipo por su id
		$collection = Collection::find($data->collection);

		//Si hay un json válido, añadir el soldado como lider del equipo
		if($data && $card && $collection){

			$cardCollection = new CardCollection();
			$cardCollection->card_id = $data->card;
			$cardCollection->collection_id = $data->collection;
			
			try{
				// Guardar el equipo
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
