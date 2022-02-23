<?php

namespace App\Http\Controllers;

use App\Events\MessageCreated;
use App\common\getPushClass;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use App\Food;
use App\Message;
use App\Store;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;


class ChatController extends Controller
{
    public function chat($id, $kind)
    {

        //firstでnew_flg付いたやつ取得して消す
        Log::debug('chat入った');
        Log::debug($kind);
        
        // チャットの画面
        $food = Food::where('foods.id',$id)
        ->join('sub_categories','foods.sub_category_id','sub_categories.api_id')
        ->select('foods.store_id','foods.plice','foods.id','sub_categories.food_name')
        ->first();
        Log::debug('food'.$food);

        $my = Store::find(session()->get('id')); //自分の情報
        $pertner = Store::find($food->store_id); //食材登録した人の情報
        $my_id = $my->id; //自分のid
        $pertner_id = $pertner->id; //食材登録した人のid

        if ($my_id == $food->store_id) { //もし自分で登録した食材なら

            $pertner = Store::find($kind); //相手は$kind id の人
            $pertner_id = $pertner->id;
        }

        Log::debug('相手のid' . $pertner_id);
        Log::debug('自分のid' . $my_id);

    
            DB::table('messages')->where('from_store', $pertner_id)->where('to_store', $my_id)->where('food_id', $food->id)->where('new_flg', true)->update(['new_flg' => false]);
        

        $query = Message::where('from_store', $pertner_id)->where('to_store', $my_id)->where('food_id', $food->id);
        $query->orwhere(function ($query) use ($pertner_id, $my_id, $food) {
            $query->where('from_store', $my_id)
                ->where('to_store', $pertner_id)
                ->where('food_id', $food->id);
        });

        $messages = $query->get();
        $axios_path = route('chat.send',['id'=>$food->id,'kind'=>$pertner->id]);

        return view('foods.chat', compact('my', 'food', 'messages', 'pertner','axios_path'));
    }



    public function chatlist($id)
    {

        $food = Food::find($id);



        $messages = Message::whereIn('id', function ($query) use ($food) {
            return $query->select(DB::raw('MAX(messages.id) As id'))
                ->from('messages')
                ->join('stores', 'messages.from_store', '=', 'stores.id')
                ->groupBy('from_store')
                ->where('from_store', '<>', session()->get('id'))
                ->where('food_id', '=', $food->id);
        });

        $stores = DB::table('stores')
            ->joinSub($messages, 'messages', 'messages.from_store', 'stores.id')
            ->get();

        Log::debug('stores' . $stores);



        return view('foods.chatlist', compact('food', 'stores'));
    }

    public function all_list()
    {

        $id = session()->get('id');

        $messages = Message::where('to_store', $id)
            ->orwhere('from_store',$id)
            ->groupBy('from_store');
       


        $stores = DB::table('stores')
            ->joinSub($messages, 'messages', 'messages.from_store', 'stores.id')
            ->select('messages.id', 'messages.to_store', 'messages.from_store', 'stores.store_name', 'messages.created_at', 'messages.food_id', 'messages.new_flg')
            ->orderBy('messages.id', 'desc')
            ->get();

      Log::debug($stores);
        $pertner = getPushClass::getPush();
        $link = route('chat.list', 0);
        return view('foods.all_mail_list', compact('stores','pertner', 'link','id'));
    }


}
