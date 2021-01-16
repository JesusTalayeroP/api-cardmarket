<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Card;
use App\Models\CardCollection;
use App\Models\Collection;
use App\Models\User;

class SaleController extends Controller
{
    public function search_card(Request $request){
    	$response = "";

    	$data = $request->getContent();

    	$data = json_decode($data);

    	$cardsCollection = CardCollection::all();

    	$response = [];
		
    	if($cardsCollection){
    		for ($i=0; $i < count($cardsCollection); $i++) { 
    			$card = Card::find($cardsCollection[$i]->card_id);

    			if(strcasecmp($card->name, $data->card) == 0){
    				$collection = Collection::find($cardsCollection[$i]->collection_id);
    				$response [] = [
    				"id" => $cardsCollection[$i]->id,
    				"name" => $card->name,
    				"description" => $card->description,
    				"collection" => $collection->name
    				];
    			}
    		}

    	} 
    	if($response == []){
    		$response = "No se encontraron cartas con ese nombre";
    	}
    	return $response;
    }

    public function create_sale(Request $request) {
    	$response = "";

    	$data = $request->getContent();

    	$data = json_decode($data);

    	$user = User::where('api_token', $data->api_token)->get()->first();
    	

    	if($data){
    		$sale = new Sale();

    		$sale->quantity = $data->quantity;
    		$sale->price = $data->price;
    		$sale->card_collection_id = $data->card_id;
    		$sale->user_id = $user->id;

			try{
				$sale->save();
				$response = "OK";
			}catch(\Exception $e){
				$response = $e->getMessage();
			}
    	} else $response = "Datos incorrectos";

    	return $response;
    }

    public function buy_card(Request $request){
    	$response = "";

    	$data = $request->getContent();

    	$data = json_decode($data);

    	$sales = Sale::orderBy('price', 'ASC')->get();

    	$response = [];
		
    	if($sales){
    		for ($i=0; $i < count($sales); $i++) { 
    			$cardCollection = CardCollection::where('id', $sales[$i]->card_collection_id)->get()->first();
				$card = Card::find($cardCollection->card_id);
    			
    			if(strcasecmp($card->name, $data->card) == 0){
    				$collection = Collection::find($cardCollection->collection_id);
    				$user = User::find($sales[$i]->user_id);
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
    	if($response == []){
    		$response = "No se encontraron cartas con ese nombre";
    	}
    	return $response;
    }
}
