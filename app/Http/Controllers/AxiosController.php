<?php

namespace App\Http\Controllers;

use App\Address;
use App\Category;
use App\Events\LikeSignale;
use App\Food;
use App\Message;
use App\Store;
use App\common\getPushClass;
use App\Decision;
use App\Like;
use App\SubCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


use Illuminate\Support\Facades\Log;

class AxiosController extends Controller
{

    ////////////////////////////いいね追加////////////////////////////////

    public function store($food_id)
    {

        $id = session()->get('id');
        $store = Store::find($id);
        $food = Food::find($food_id);
        $like_one = Like::where('store_id', $id)->where('food_id', $food_id)->get();


        if ($like_one->count() > 0) {
            Log::debug('trueだよ');

            $food->likes = 0;
            $food->save();
            Like::where('store_id', $store->id)->where('food_id', $food_id)->delete();
        } else {

            Log::debug('falseだよ');
            $food->likes = 1;
            $food->save();
            $like = Like::firstOrCreate(
                array(
                    'store_id' => $store->id,
                    'to_store' => $food->store_id,
                    'food_id' => $food->id,
                    'new_flg' => 1,
                )
            );
            
            event(new LikeSignale($like));
        }
    }
    //==========================メッセージ取得=============================
    public function get_message()
    {
        $pertner = getPushClass::getPush();

        Log::debug('メッセージ取得:' . $pertner);
        return $pertner;
    }
    //=======================================================
    public function get_sub()
    {
        Log::debug('get_sub入った');
        $sub_categories = SubCategory::all();
        $categories = Category::all();
        $meet = SubCategory::where('parent_id', 10)->get();
        $beji = SubCategory::where('parent_id', 12)->get();
        $fish = SubCategory::where('parent_id', 11)->get();
        $fruite = SubCategory::where('parent_id', 34)->get();
        $soupe = SubCategory::where('parent_id', 17)->get();
        $drink = SubCategory::where('parent_id', 27)->get();
        $spice = SubCategory::where('parent_id', 19)->get();
        $tool = SubCategory::where('parent_id', 40)->get();
        $sweet = SubCategory::where('parent_id', 21)->get();
        $pan = SubCategory::where('parent_id', 22)->get();
        $egg = SubCategory::where('parent_id', 33)->get();


        return [
            'sub_categories' => $sub_categories,
            'categories' => $categories,
            'meet' => $meet,
            'beji' => $beji,
            'fish' => $fish,
            'fruite' => $fruite,
            'soupe' => $soupe,
            'drink' => $drink,
            'spice' => $spice,
            'tool' => $tool,
            'sweet' => $sweet,
            'pan' => $pan,
            'egg' => $egg
        ];
    }
    ////////////////////////////郵便番号取得/////////////////////////////////
    public function get_post()
    {

        $id = session()->get('id');
        if ($id) {

            $store = Store::find($id);
            $address = Address::where('store_id', $store->id)->first();

            return $address;
        } else {
            return;
        }
    }
    ////////////////////////////店舗情報取得/////////////////////////////////
    public function get_store()
    {
    }
    ////////////////////////////この人に決定/////////////////////////////////
    public function decision($food_id)
    {

        $food = Food::find($food_id);


        if ($food->decision_flg) {
            Log::debug('trueだよ');

            $food->decision_at = null;
            $food->decision_flg = false;
            $food->save();
        } else {
            Log::debug('falseだよ');
            $dt = Carbon::now();
            $food->decision_at = $dt->addDay(4);
            $food->decision_flg = true;
            $food->save();
        }
        return $food;
    }

    
    public function get_all($id)
    {
        $min = ($id - 1) * 4;
        $max = 4;
      Log::debug('はじまり'.$min);
      Log::debug('limit'.$max);
        $u_id = session()->get('id');
        $foods = Food::where('store_id', $u_id)
            ->join('sub_categories', 'foods.sub_category_id', '=', 'sub_categories.api_id')
            ->select('foods.id', 'sub_categories.food_name', 'foods.plice', 'foods.loss_limit', 'foods.pic1', 'foods.store_id', 'foods.decision_flg')
            ->get();
        $page = Food::where('store_id', $u_id)
            ->join('sub_categories', 'foods.sub_category_id', '=', 'sub_categories.api_id')
            ->select('foods.id', 'sub_categories.food_name', 'foods.plice', 'foods.loss_limit', 'foods.pic1', 'foods.store_id', 'foods.decision_flg')
            ->orderBy('id')
            ->offset($min)
            ->limit($max)
            ->get();
        
        return ['all'=>$foods,'page'=>$page];
    }


    public function get_like($id)
    {
        $u_id = session()->get('id');
        $min = ($id - 1) * 4;
        $max = 4;
        $foods = Food::where('foods.store_id', '<>', $u_id)
            ->join('likes', 'foods.id', '=', 'likes.food_id')
            ->join('sub_categories', 'foods.sub_category_id', '=', 'sub_categories.api_id')
            ->where('likes.store_id', $u_id)
            ->select('foods.id', 'foods.store_id', 'likes.to_store', 'sub_categories.food_name', 'foods.plice', 'foods.loss_limit', 'foods.pic1', 'foods.decision_flg')
            // ->groupBy('foods.store_id')
            ->get();

        $page = Food::where('foods.store_id', '<>', $u_id)
            ->join('likes', 'foods.id', '=', 'likes.food_id')
            ->join('sub_categories', 'foods.sub_category_id', '=', 'sub_categories.api_id')
            ->where('likes.store_id', $u_id)
            ->select('foods.id', 'foods.store_id', 'likes.to_store', 'sub_categories.food_name', 'foods.plice', 'foods.loss_limit', 'foods.pic1', 'foods.decision_flg')
            ->orderBy('id')
            ->offset($min)
            ->limit($max)
            // ->groupBy('foods.store_id')
            ->get();


        return ['all'=>$foods,'page'=>$page];
    }
    public function re_like($id)
    {
        $u_id = session()->get('id');
        $min = ($id - 1) * 4;
        $max = 4;

        $foods = Food::where('foods.store_id', $u_id)
            ->where('foods.store_id', $u_id)
            ->join('likes', 'foods.id', '=', 'likes.food_id')
            ->join('sub_categories', 'foods.sub_category_id', '=', 'sub_categories.api_id')
            ->where('likes.to_store', $u_id)
            ->select('foods.id', 'foods.store_id', 'sub_categories.food_name', 'foods.plice', 'foods.loss_limit', 'foods.pic1', 'to_store', 'foods.decision_flg')
            ->groupBy('sub_categories.food_name')
            ->get();

        $page = Food::where('foods.store_id', $u_id)
            ->where('foods.store_id', $u_id)
            ->join('likes', 'foods.id', '=', 'likes.food_id')
            ->join('sub_categories', 'foods.sub_category_id', '=', 'sub_categories.api_id')
            ->where('likes.to_store', $u_id)
            ->select('foods.id', 'foods.store_id', 'sub_categories.food_name', 'foods.plice', 'foods.loss_limit', 'foods.pic1', 'to_store', 'foods.decision_flg')
            ->groupBy('sub_categories.food_name')
            ->orderBy('id')
            ->offset($min)
            ->limit($max)
            ->get();
        return ['all'=>$foods,'page'=>$page];
    }
    public function get_decision($id)
    {
        $min = ($id - 1) * 4;
        $max = 4;
        $foods = Food::where('decision_flg', true)
            ->join('sub_categories', 'foods.sub_category_id', '=', 'sub_categories.api_id')
            ->select('foods.id', 'foods.store_id', 'sub_categories.food_name', 'foods.plice', 'foods.loss_limit', 'foods.pic1', 'foods.decision_flg')
            ->get();
        $page = Food::where('decision_flg', true)
            ->join('sub_categories', 'foods.sub_category_id', '=', 'sub_categories.api_id')
            ->select('foods.id', 'foods.store_id', 'sub_categories.food_name', 'foods.plice', 'foods.loss_limit', 'foods.pic1', 'foods.decision_flg')
            ->orderBy('id')
            ->offset($min)
            ->limit($max)
            ->get();
        return ['all'=>$foods,'page'=>$page];
    }
    //food削除処理
    public function delete_food($id)
    {

        $food = Food::find($id);
        //実際のディレクトリからも削除
        if ($food->pic1) {
            Storage::disk('public')->delete('images/' . $food->pic1);
        }

        if ($food->pic2) {
            Storage::disk('public')->delete('images' . $food->pic2);
        }

        if ($food->pic3) {
            Storage::disk('public')->delete('images' . $food->pic3);
        }
        $like = Like::where('food_id', $id)->where('store_id', session()->get('id'))->delete();
        Log::debug('LIKE delete');
        $messages = Message::where('food_id', $id)->delete();
        Log::debug('Message delete');

        // $like->delete();
        $food->delete();
        // $messages->delete();

        return redirect()->route('mypage')->with('flash_message', __('DELETED'));
    }

    //item_list画面サブカテゴリーで検索
    public function search_food($id, $val)
    {

        if ($val == 0) {
            Log::debug('valは０');
            $stores = DB::table('stores')
                ->join('address', 'stores.id', '=', 'address.store_id')
                ->join('foods', 'stores.id', '=', 'foods.store_id')
                ->join('sub_categories', 'foods.sub_category_id', '=', 'sub_categories.api_id')
                ->select('store_name', 'foods.id', 'foods.store_id', 'sub_categories.food_name', 'foods.plice', 'foods.loss_limit', 'foods.pic1', 'sub_categories.api_id', 'foods.category_id')
                ->where('category_id', $id)
                ->where('decision_flg', false)
                ->get();
        } else {

            Log::debug('valはあり');
            $stores = DB::table('stores')
                ->join('address', 'stores.id', '=', 'address.store_id')
                ->join('foods', 'stores.id', '=', 'foods.store_id')
                ->join('sub_categories', 'foods.sub_category_id', '=', 'sub_categories.api_id')
                ->select('store_name', 'foods.id', 'foods.store_id', 'sub_categories.food_name', 'foods.plice', 'foods.loss_limit', 'foods.pic1', 'sub_categories.api_id', 'foods.category_id')
                ->where('category_id', $id)
                ->where('sub_categories.api_id', $val)
                ->where('decision_flg', false)
                ->get();
        }

        return $stores;
    }

    //paging処理
    public function p_decision($id)
    {

        Log::debug('decision入った');
        $min = ($id - 1) * 4;
        $max = 4;
       
        $page = Food::where('decision_flg', true)
            ->join('sub_categories', 'foods.sub_category_id', '=', 'sub_categories.api_id')
            ->select('foods.id', 'foods.store_id', 'sub_categories.food_name', 'foods.plice', 'foods.loss_limit', 'foods.pic1', 'foods.decision_flg')
            ->orderBy('id')
            ->offset($min)
            ->limit($max)
            ->get();

        return $page;
    
    }

    
}
