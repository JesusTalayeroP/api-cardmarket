<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;
use App\Models\Collection;

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
				$response = "OK";
			}catch(\Exception $e){
				$response = $e->getMessage();
			}			
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

    	} else $response = "Datos incorrectos o la colección no existe";

    	return $response;
    }
}
