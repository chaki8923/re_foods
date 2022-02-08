<?php

namespace App\Http\Controllers\Ajax;

use App\Events\MessageCreated;

use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use App\Food;
use App\Message;
use App\Store;

use Illuminate\Support\Facades\Log;


class ChatRoomController extends Controller
{

  public function create(Request $request, $id, $kind)
  {
    $food = Food::find($id);

    Log::debug('create入った');
 
    Log::debug($kind);

    $my = Store::find(session()->get('id'));
    $pertner = Store::find($food->store_id);
  
    if($my->id == $food->store_id){
      
   
      $pertner = Store::find($kind);
    }


    $message = Message::create([
      'body' => $request->message,
      'from_store' => $my->id,
      'to_store' => $pertner->id,
      'food_id' => $food->id,
      'new_flg'=>true
    ]);


    Log::debug('MessageCreated発動');
    event(new MessageCreated($message));
    
    
    return $message;
  }



  public function index($id,$kind)
  {

    Log::debug('index入った');

    Log::debug($kind);
    $food = Food::find($id);
    $my = Store::find(session()->get('id'));
    $pertner = Store::find($food->store_id);
    
    $my_id = $my->id;
    $pertner_id = $pertner->id;
    if($my_id == $food->store_id){
     
      $pertner = Store::find($kind);
      $pertner_id = $pertner->id;
  }

  
    

    
    $query = Message::where('from_store', $pertner_id)->where('to_store', $my_id)->where('food_id',$food->id);
    
    $query->orwhere(function ($query) use ($pertner_id,$my_id,$food) {
      $query->where('from_store', $my_id)
      ->where('to_store', $pertner_id)
      ->where('food_id',$food->id);
    });
    
    
    $messages = $query->get();


    return $messages;
  }
}
