<?php

namespace App\Http\Controllers;

use App\Address;
use App\Category;
use App\Food;
use App\Message;
use App\Store;
use Illuminate\Support\Facades\DB;
use App\common\getPushClass;
use App\Like;
use App\SubCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\IdentityProvider;
use App\Mail\ContactMail;
use Exception;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Requests\ContactVeridation;


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
        if(session()->get('id')){
            return redirect()->route('action',session()->get('id'));
        }
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
            return redirect()->route('signin')->with('flash_message', __('入力内容に誤りがあります'));
        }

        if (Hash::check($request->password, $store[0]->password)) {
            session(['store_name' => $store[0]->store_name]);
            session(['email' => $store[0]->email]);
            session(['id' => $store[0]->id]);


            return redirect()->route('action', $store[0]->id)->with(['flash_message' => __('Logined'), 'logined' => 1]);
            //id渡したいならこうやって
            // return redirect()->route('top_page',$store[0]->id)->with('flash_message',__('Logined'));

        } else {

            return redirect()->route('signin')->with('flash_message', __('入力内容に誤りがあります'));
        }
    }

    //ソーシャルログイン

    public function redirectToProvider($social)
    {
        Log::debug('ソーシャル');
        return Socialite::driver($social)->redirect();
    }


    public function handleProviderCallback($provider)
    {
        try {
            Log::debug('handleProviderCallbackです');
            $user = Socialite::driver($provider)->user();
            $store  = Store::select('*')->where('email', $user['email'])->first();
            Log::debug(print_r($user, true));

            session(['store_name' => $store->store_name]);
            session(['id' => $store->id]);
            session(['email' => $store->email]);

            return redirect()->route('action', $store->id)->with('flash_message', __('ログインしました。'));
        } catch (Exception $e) {


            redirect()->route('forget')->with('flash_message', __('新規登録してください'));
        }

        $authUser = $this->findOrCreateUser($user, $provider);
        if ($authUser !== null) {
            Log::debug('管理者' . $authUser);
            $store = Store::select('*')->where('id', $authUser['id'])->first();
            session(['store_name' => $store->store_name]);
            session(['id' => $store->id]);
            session(['email' => $store->email]);

            return redirect()->route('action', $store->id)->with('flash_message', __('ログインしました。'));
        }
        // Auth::login($authUser, true);


    }

    public function findOrCreateUser($providerUser, $provider)
    {
        $account = IdentityProvider::whereProviderName($provider)
            ->whereProviderId($providerUser->getId())
            ->first();

        if ($account) {
            Log::debug('アカウントあり');
            return $account->user;
        } else {
            $user = Store::whereEmail($providerUser->getEmail())->first();

            if (!$user) {
                Log::debug('ユーザーなし');
                $address = new Address;
                $user = Store::create([
                    'email' => $providerUser->getEmail(),
                    'store_name'  => $providerUser->getName(),
                ]);
                Log::debug('新ユーザー' . $user);
                Log::debug('新ユーザーID' . $user['id']);
                Address::create([
                    'store_id' => $user['id']
                ]);
            }

            $user->IdentityProviders()->create([
                'provider_id'   => $providerUser->getId(),
                'provider_name' => $provider,
            ]);

            return $user;
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

        
        $store = Store::find($id);
        if(!$store){
            return view('errors.404');
        }
        
        $stores = Store::all();
        if($store->id !== session()->get('id')){
            return redirect()->route('action',session()->get('id'));
        } 

       
        $today = Carbon::now(); //現在日時
        $limit = new Carbon('+1 day');
        $del_foods = Food::where('decision_flg', true)->get(); //今より3日前に成約した食材取得
        $foods = Food::all();



        foreach ($del_foods as $val) {
            Log::debug('削除食材' . $del_foods);

            //成約から３日経った、または賞味期限が３日前になったら削除
            if ($val->decision_at <= $today) {
                if ($val->pic1) {

                    Storage::disk('public')->delete('images/' . $val->pic1);
                }
                if ($val->pic2) {

                    Storage::disk('public')->delete('images/' . $val->pic2);
                }
                if ($val->pic3) {

                    Storage::disk('public')->delete('images/' . $val->pic3);
                }
                Like::where('food_id', $val->id)->where('store_id', session()->get('id'))->delete();
                Message::where('food_id', $val->id)->delete();
                $val->delete();
            }
        }

        foreach ($foods as $val) {


            if ($val->loss_limit <= $limit) {
                if ($val->pic1) {

                    Storage::disk('public')->delete('images/' . $val->pic1);
                }
                if ($val->pic2) {

                    Storage::disk('public')->delete('images/' . $val->pic2);
                }
                if ($val->pic3) {

                    Storage::disk('public')->delete('images/' . $val->pic3);
                }
                Like::where('food_id', $val->id)->where('store_id', session()->get('id'))->delete();
                Message::where('food_id', $val->id)->delete();
                $val->delete();
            }
        }

        $new_msg = Message::where('new_flg', true)->groupBy('from_store')->get();


        
        $my_food_id = Food::where('store_id', $id)->select('id')->get();
        $address = Address::where('store_id', $id)->first();
        $my_address = Address::where('address',$address->address)->where('store_id','<>',$id)->get();

        $pertner = getPushClass::getPush();
        Log::debug('パートナー中身' . $pertner);
        $detail_link = route('item_detail', 0);

        if ($pertner->isEmpty()) {
            $link = route('chat.list', 0);
        } else {
            $link = route('chat.list', $pertner[0]->food_id);
        }




        $likes = Like::where('new_flg', true)
            ->join('stores', 'likes.store_id', '=', 'stores.id')
            ->where('store_id', '<>', session()->get('id'))
            ->where('to_store', '=', session()->get('id'))
            ->groupBy('food_id')
            ->get();
        Log::debug('likes' . $likes);



        return view('foods.action', compact('store', 'foods', 'new_msg', 'pertner', 'link', 'my_food_id', 'likes', 'detail_link', 'address','my_address','stores'));
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
        $address = Address::where('store_id', session()->get('id'))->first();

        $foods = [];
        for ($i = 1; $i <= $catNum; $i++) {
            $foods[$i] = Food::where('category_id', $i)
                ->where('decision_flg', false)->where('address', $address->address)
                ->get();
        }
        $pertner = getPushClass::getPush();

        Log::debug('カテゴリー' . $categories);
        $link = route('chat.list', 0);



        return view('foods.safefood', compact('categories', 'foods', 'pertner', 'link'));
    }
    //=======================================================
    //==========================PERTNERカテゴリー一覧=============================
    public function pertner_show($id)
    {

        $foods = Food::where('store_id', $id)
            ->join('categories', 'categories.id', 'foods.category_id')
            ->select('category_id', 'category_name', 'category_image')
            ->selectRaw('COUNT(category_id) as count_cat')
            ->groupBy('foods.category_id')
            ->get();

        $catNum = $foods->count();

        $all_food = Food::all();

        $pertner = getPushClass::getPush();

        //自分のID
        $u_id = session()->get('id');

        //相手のID
        $p_id = $id;
        $link = route('chat.list', 0);



        return view('foods.pertner_foods', compact('foods', 'all_food', 'pertner', 'link', 'u_id', 'p_id'));
    }
    //=======================================================

    //========================品物一覧===============================
    public function item_list($id)
    {
        $category = Category::find($id);

        if(!$category){
            return view('errors.404');
        }
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
            ->where('foods.address', $address->address)
            ->get();

        $sub_cat = SubCategory::where('parent_id', $category->api_id)->get();
        $pertner = getPushClass::getPush();

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



        return view('foods.item_list', compact('stores', 'pertner', 'link', 'u_id', 'detail_link', 'edit_link', 'sub_cat', 'cat_id', 'about_link', 'rule_link', 'legal_link', 'privacy_link', 'contact_link'));
    }



    //========================品物詳細===============================
    public function item_detail($id)
    {
        $food = Food::find($id);

        if(!$food){
            return view('errors.404');
        }
        $store = Store::find(session()->get('id'));
        $category = Category::find($food->category_id);
        $sub_category = SubCategory::where('api_id', $food->sub_category_id)->first();
        $like_one = Like::where('store_id', session()->get('id'))->where('food_id', $id)->get();
        $messages = Message::where('to_store', $store->id)->get();
        $decision_link = route('decision',['food_id'=>$food->id]);
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
        $pertner = getPushClass::getPush();
        $like_list_link =  route('like_list', ['id'=>$food->id]);

        if ($pertner->isEmpty()) {
            $link = route('chat.list', 0);
        } else {
            $link = route('chat.list', $pertner[0]->food_id);
        }
        $axios_path = route('like.add', ['id'=>$food->id]);

        $user_id = session()->get('id');
        return view('foods.fooddetail', compact('store', 'food', 'category', 'likes', 'like_one', 'message_num', 'sub_category', 'root', 'link', 'user_id', 'abater','decision_link','like_list_link','axios_path'));
    }
    //=========================食材編集==============================

    public function food_edit_show($id)
    {

        $food = Food::find($id);
        $store = Store::find(session()->get('id'));

        if(!$food){
            return view('errors.404');
        }elseif($food->store_id !== $store->id){
            return redirect()->route('action',$store->id)->with('flash_message', __('不正な操作が行われました。'));
        }
        $categories = Category::all();
        $sub_categories = SubCategory::all();
        $cat = Category::find($food->category_id);
        Log::debug('cat中身' . $cat);



        return view('foods.foodEdit', compact('categories', 'store', 'sub_categories', 'cat', 'food'));
    }






    //=========================USER 詳細==============================
    public function user_detail($id)
    {
        $check = Store::find($id);
        if(!$check){
            return view('errors.404');
        }
        Log::debug('相手ID'.$id);
        Log::debug('自分ID'.session()->get('id'));
        $like_check = Like::select('id')->where('store_id',$id)->where('to_store',session()->get('id'))->first();
        Log::debug('チェックID'.$like_check);
        if(!$like_check){
            return redirect()->route('action',session()->get('id'))->with('flash_message', __('不正な操作が行われました。'));
        }
        $store = Store::find($id)
            ->join('address', 'stores.id', '=', 'address.store_id')
            ->where('address.store_id', $id)
            ->first();
        
        $message = Message::get('id')->where('from_store')->first();
        $pertner = getPushClass::getPush();
        $link = route('chat.list', 0);
        $foods = Food::where('store_id', $id)->get();
        $foods_num = $foods->count();

        Log::debug('店舗情報'.$store);


        return view('foods.user_detail', compact('store', 'pertner', 'link', 'foods_num'));
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

        $pertner = getPushClass::getPush();


        if ($pertner->isEmpty()) {
            $link = route('chat.list', 0);
        } else {
            $link = route('chat.list', $pertner[0]->food_id);
        }



        return view('foods.like_list', compact('stores', 'food', 'likes', 'pertner', 'link'));
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
        $pertner = getPushClass::getPush();

        $u_id = session()->get('id');
        if ($pertner->isEmpty()) {
            $link = route('chat.list', 0);
        } else {
            $link = route('chat.list', $pertner[0]->food_id);
        }

        $detail_link = route('item_detail', 0);
        $edit_link = route('item_edit_show', 0);
        $delete_link = route('delete_food', 0);
        $about_link = route('about');
        $rule_link = route('rule');
        $legal_link = route('legal');
        $privacy_link = route('privacy');
        $contact_link = route('contact');


        return view('foods.mypage', compact('pertner', 'link', 'detail_link', 'edit_link', 'delete_link', 'u_id', 'about_link', 'rule_link', 'legal_link', 'privacy_link', 'contact_link', 'categories'));
    }

    //=========================利用規約など==============================

    public function rule()
    {
        return view('foods.rule');
    }

    public function about()
    {
        return view('foods.about');
    }

    public function legal()
    {
        return view('foods.legal');
    }

    public function privacy()
    {
        return view('foods.privacy');
    }
    //=========================問い合わせ==============================
    public function contact()
    {
        return view('foods.contact');
    }

    public function sendmail(ContactVeridation $request)
    {

        Log::debug('送信処理');
        $to = 'konkuriitonouenokareha128@gmail.com';
        $name = $request->store_name;
        $email = $request->email;
        $text = $request->message;


        Mail::to($to)->send(new ContactMail($text, $name, $email));

        return redirect()->route('contact')->with('flash_message', __('メッセージを送信しました。'));
    }
}
