<?php

namespace App\Http\Controllers;

use App\Address;
use App\Category;
use App\Events\LikeSignale;
use App\Food;
use App\Message;
use App\Store;
use Illuminate\Support\Facades\DB;
// use App\common\getPushClass;
use App\Like;
use App\SubCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\ErrorHandler\Debug;


class MyFoodsController extends Controller
{

    //新規登録
    public function signup()
    {

        return view('foods.signup');
    }

    //======================TOP=================================
    public function top_page()
    {
        session()->forget('email');
        return view('foods.top_page');
    }
    //=======================================================






    //=======================ログイン処理================================

    public function signin()
    {

        return view('foods.signin');
    }

    public function auth(Request $request)
    {

        $store = Store::where('email', $request->email)->get();


        if (count($store) === 0) {
            return redirect()->route('signin')->with('flash_message', __('invalid error'));
        }

        if (Hash::check($request->password, $store[0]->password)) {
            session(['store_name' => $store[0]->store_name]);
            session(['email' => $store[0]->email]);
            session(['id' => $store[0]->id]);


            return redirect()->route('action', $store[0]->id)->with(['flash_message' => __('Logined'), 'logined' => 1]);
            //id渡したいならこうやって
            // return redirect()->route('top_page',$store[0]->id)->with('flash_message',__('Logined'));

        } else {

            return redirect()->route('signin')->with('flash_message', __('invalid erroe'));
        }
    }
    //=======================================================

    //========================ログアウト===============================

    public function logout()
    {
        session()->forget('store_name');
        session()->forget('email');
        return redirect('/');
    }
    //=======================================================

    //=======================アクション選択画面================================

    public function action($id)
    {
        
        $today = Carbon::now();//現在日時
        $limit = new Carbon('+1 day');
        $del_foods = Food::where('decision_flg',true)->get();//今より3日前に成約した食材取得
        $foods = Food::all();

     
        
        foreach($del_foods as $val){
            Log::debug('削除食材'.$del_foods);

            //成約から３日経った、または賞味期限が３日前になったら削除
                if($val->decision_at <= $today){
                    if($val->pic1){
                        
                        Storage::disk('public')->delete('images/' . $val->pic1);
                    }
                    if($val->pic2){

                        Storage::disk('public')->delete('images/' . $val->pic2);
                    }
                    if($val->pic3){

                        Storage::disk('public')->delete('images/' . $val->pic3);
                    }
                    Like::where('food_id',$val->id)->where('store_id',session()->get('id'))->delete();
                    Message::where('food_id',$val->id)->delete();
                    $val->delete();
                    
                }
            
        }
   
        foreach($foods as $val){

   
                if($val->loss_limit <= $limit){
                    if($val->pic1){

                        Storage::disk('public')->delete('images/' . $val->pic1);
                    }
                    if($val->pic2){

                        Storage::disk('public')->delete('images/' . $val->pic2);
                    }
                    if($val->pic3){

                        Storage::disk('public')->delete('images/' . $val->pic3);
                    }
                    Like::where('food_id',$val->id)->where('store_id',session()->get('id'))->delete();
                    Message::where('food_id',$val->id)->delete();
                    $val->delete();
                
                }
            
        }
        
        $new_msg = Message::where('new_flg', true)->groupBy('from_store')->get();


        $store = Store::find($id);
        $my_food_id = Food::where('store_id', $id)->select('id')->get();

        // $pertner = getPushClass::getPush();
        $detail_link = route('item_detail', 0);

        // if ($pertner->isEmpty()) {
        //     $link = route('chat.list', 0);
        // } else {
        //     $link = route('chat.list', $pertner[0]->food_id);
        // }
    
        $link = route('chat.list', 0);
        

        $likes = Like::where('new_flg', true)
            ->join('stores', 'likes.store_id', '=', 'stores.id')
            ->where('store_id', '<>', session()->get('id'))
            ->where('to_store', '=', session()->get('id'))
            ->groupBy('food_id')
            ->get();
        Log::debug('likes' . $likes);


        return view('foods.action', compact('store', 'foods','link', 'new_msg', 'my_food_id', 'likes', 'detail_link'));
        // return view('foods.action', compact('store', 'foods', 'new_msg', 'pertner', 'link', 'my_food_id', 'likes', 'detail_link'));
    }


    //========================食材登録画面===============================

    public function food_regist_show($id)
    {

        $categories = Category::all();
        $store = Store::find($id);
        $sub_categories = SubCategory::all();

        foreach ($sub_categories as $sub) :
        endforeach;

        return view('foods.foodRegister', compact('categories', 'store', 'sub_categories', 'sub'));
    }



    //==========================カテゴリー一覧=============================
    public function foods_show()
    {


        $categories = Category::all();
        $catNum = $categories->count();

        $foods = [];
        for ($i = 1; $i <= $catNum; $i++) {
            $foods[$i] = Food::where('category_id', $i)
                ->where('decision_flg', false)
                ->get();
        }
        // $pertner = getPushClass::getPush();

        Log::debug('カテゴリー' . $categories);
        $link = route('chat.list', 0);



        return view('foods.safefood', compact('categories', 'foods','link'));
        // return view('foods.safefood', compact('categories', 'foods', 'pertner', 'link'));
    }
    //=======================================================
    //==========================PERTNERカテゴリー一覧=============================
    public function pertner_show($id)
    {

        $foods = Food::where('store_id', $id)
        ->join('categories', 'categories.id', 'foods.category_id')
        ->select('category_id','category_name','category_image')
        ->selectRaw('COUNT(category_id) as count_cat')
        ->groupBy('foods.category_id')
        ->get();

        $catNum = $foods->count();

       $all_food = Food::all();

        // $pertner = getPushClass::getPush();

        //自分のID
        $u_id = session()->get('id');
        Log::debug('foods' . $foods);
        //相手のID
        $p_id = $id;
        $link = route('chat.list', 0);



        return view('foods.pertner_foods', compact('foods','all_food', 'pertner', 'link', 'u_id', 'p_id'));
    }
    //=======================================================

    //========================品物一覧===============================
    public function item_list($id)
    {
        //最後に下記コードを検索条件に加える
        $address = Address::where('store_id', session()->get('id'))->first();
        $u_id = session()->get('id');
        //店舗、住所、食材、サブカテゴリーjoin
        $stores = DB::table('stores')
            ->join('address', 'stores.id', '=', 'address.store_id')
            ->join('foods', 'stores.id', '=', 'foods.store_id')
            ->join('sub_categories', 'foods.sub_category_id', '=', 'sub_categories.api_id')
            ->select('store_name', 'foods.id', 'foods.store_id', 'sub_categories.food_name', 'foods.plice', 'foods.loss_limit', 'foods.pic1', 'sub_categories.api_id', 'foods.category_id')
            ->where('category_id', $id)
            ->where('decision_flg', false)
            ->get();

        $category = Category::find($id);
        $sub_cat = SubCategory::where('parent_id', $category->api_id)->get();
        // $pertner = getPushClass::getPush();

        Log::debug('store中身' . $stores);

        $link = route('chat.list', 0);


        $cat_id = $id;

        $detail_link = route('item_detail', 0);
        $edit_link = route('item_edit_show', 0);
        $about_link = route('about');
        $rule_link = route('rule');
        $legal_link = route('legal');
        $privacy_link = route('privacy');
        $contact_link = route('contact');


        return view('foods.item_list', compact('stores',  'link', 'u_id', 'detail_link', 'edit_link', 'sub_cat', 'cat_id','about_link','rule_link','legal_link','privacy_link','contact_link'));
        // return view('foods.item_list', compact('stores', 'pertner', 'link', 'u_id', 'detail_link', 'edit_link', 'sub_cat', 'cat_id','about_link','rule_link','legal_link','privacy_link','contact_link'));
    }



    //========================品物詳細===============================
    public function item_detail($id)
    {
        $food = Food::find($id);
        $store = Store::find(session()->get('id'));
        $category = Category::find($food->category_id);
        $sub_category = SubCategory::where('api_id', $food->sub_category_id)->first();
        $like_one = Like::where('store_id', session()->get('id'))->where('food_id', $id)->get();
        $messages = Message::where('to_store', $store->id)->get();

        //投稿者の情報
        $abater = Store::find($food->store_id);
        $likes = Like::where('food_id', $id)->get();

        //自分の登録した食材の詳細画面ならnew_flg外す
        if ($food->store_id == session()->get('id')) {
            $new_like = Like::where('food_id', $id)
                ->where('new_flg', true)
                ->get();
            foreach ($new_like as $new) :
                $new->new_flg = 0;
                $new->save();
            endforeach;
        }
        $message_num = $messages->count();

        $root = route('like_list', $food->id);
        // $pertner = getPushClass::getPush();


        // if ($pertner->isEmpty()) {
        //     $link = route('chat.list', 0);
        // } else {
        //     $link = route('chat.list', $pertner[0]->food_id);
        // }
        $link = route('chat.list', 0);
        $user_id = session()->get('id');
        // return view('foods.fooddetail', compact('store', 'food', 'category', 'likes', 'like_one', 'message_num', 'sub_category', 'root', 'link', 'user_id', 'abater'));
        return view('foods.fooddetail', compact('store', 'food', 'category', 'likes', 'like_one', 'message_num', 'sub_category', 'link','root', 'user_id', 'abater'));
    }
    //=========================食材編集==============================

    public function food_edit_show($id)
    {

        $categories = Category::all();
        $store = Store::find(session()->get('id'));
        $sub_categories = SubCategory::all();
        $food = Food::find($id);
        $cat = Category::find($food->category_id);
        Log::debug('cat中身' . $cat);



        return view('foods.foodEdit', compact('categories', 'store', 'sub_categories', 'cat', 'food'));
    }






    //=========================USER 詳細==============================
    public function user_detail($id)
    {
        $store = Store::find($id)
            ->join('address', 'stores.id', '=', 'address.store_id')
            ->where('address.store_id', $id)
            ->first();
        // $pertner = getPushClass::getPush();
        $link = route('chat.list', 0);
        $foods = Food::where('store_id', $id)->get();
        $foods_num = $foods->count();

        Log::debug($store);

        return view('foods.user_detail', compact('store', 'foods_num','link'));
        // return view('foods.user_detail', compact('store', 'pertner', 'link', 'foods_num'));
    }


    //=========================LIKE LIST==============================
    public function like_list($id)
    {
        //decisionテーブルとの結合必要
        $likes = Like::where('food_id', $id)->count();
        //配列の中身からかどうか
        $food = Food::find($id);
        $stores = Store::join('likes', 'likes.store_id', '=', 'stores.id')
            ->where('food_id', $id)
            ->get();
        Log::debug($stores);

        // $pertner = getPushClass::getPush();


        // if ($pertner->isEmpty()) {
        //     $link = route('chat.list', 0);
        // } else {
        //     $link = route('chat.list', $pertner[0]->food_id);
        // }
        $link = route('chat.list', 0);

        return view('foods.like_list', compact('stores', 'food', 'likes','link'));
        // return view('foods.like_list', compact('stores', 'food', 'likes', 'pertner', 'link'));
    }
    //=========================Prof edit==============================
    public function prof_edit_view()
    {
        $id = session()->get('id');
        $store = Store::find($id);
        $address = Address::where('store_id', $store->id)->first();
        return view('foods.profedit', compact('store', 'address'));
    }


    public function uniqe_edit_view()
    {
        $id = session()->get('id');
        $store = Store::find($id);

        return view('foods.uniqe_edit', compact('store'));
    }
    //=========================Mypage==============================
    
    //気になるもの、成約済み、大カテゴリーをタブ切り替え
    public function mypage_show()
    {
        $categories = Category::all();
        // $pertner = getPushClass::getPush();

        $u_id = session()->get('id');
        // if ($pertner->isEmpty()) {
        //     $link = route('chat.list', 0);
        // } else {
        //     $link = route('chat.list', $pertner[0]->food_id);
        // }
        $link = route('chat.list', 0);
        $detail_link = route('item_detail', 0);
        $edit_link = route('item_edit_show', 0);
        $delete_link = route('delete_food', 0);
        $about_link = route('about');
        $rule_link = route('rule');
        $legal_link = route('legal');
        $privacy_link = route('privacy');
        $contact_link = route('contact');
        
        return view('foods.mypage', compact('detail_link', 'edit_link', 'delete_link', 'u_id','about_link','rule_link','legal_link','privacy_link','contact_link','categories','link'));
        // return view('foods.mypage', compact('pertner', 'link', 'detail_link', 'edit_link', 'delete_link', 'u_id','about_link','rule_link','legal_link','privacy_link','contact_link','categories'));
    }
    
    //=========================利用規約など==============================
    
    public function rule(){
        return view('foods.rule');
    }
    
    public function about(){
        return view('foods.about');
    }
    
    public function legal(){
        return view('foods.legal');
    }
    
    public function privacy(){
        return view('foods.privacy');
    }
    //=========================問い合わせ==============================
    public function contact(){
        return view('foods.contact');
    }
}
