<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

///////////////////////////////TOP PAGE////////////////////////////////////
Route::get('/', 'MyFoodsController@top_page')->name('top_page');
//////////////////////////////////////////////////////////////////////////////


///////////////////////////////ユーザー登録&認証系////////////////////////////////////
Route::get('/register', 'MyFoodsController@signup')->name('signup');
Route::get('/signup', 'MyFoodsController@signup')->name('signup');
Route::post('/signup', 'RegisterController@register')->name('register');
Route::get('/signin', 'MyFoodsController@signin')->name('signin')->middleware('short');
Route::post('/signin', 'MyFoodsController@auth')->name('auth');
Route::get('/signin/{provider}', 'MyFoodsController@redirectToProvider')->where('social', 'google|facebook|line');
Route::get('/signin/{provider}/callback', 'MyFoodsController@handleProviderCallback')->where('social', 'google|facebook|line');
//////////////////////////////////////////////////////////////////////////////

///////////////////////////////パスワードリセット////////////////////////////////////
Route::get('/pass_forget', 'RegisterController@forget')->name('forget');
Route::post('/pass_forget', 'RegisterController@forget_mail')->name('forget_mail');
Route::get('/reset_pass', 'RegisterController@reset')->name('reset');
Route::post('/reset_pass', 'RegisterController@reset_mail')->name('reset_mail');
// 送信メール本文のプレビュー

//////////////////////////////////////////////////////////////////////////////


///////////////////////////////食材登録画面////////////////////////////////////
Route::post('/', 'MyFoodsController@register')->name('food_register');
Route::post('/food_register', 'RegisterController@food_regist')->name('food_regist');
Route::get('/food_register/{id}', 'MyFoodsController@food_regist_show')->name('food_register_show');
Route::get('/ajax/food_register', 'AxiosController@get_sub')->name('get_sub');
//////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////HOME/////////////////////////////////////////
Route::get('/action/{id}', 'MyFoodsController@action')->name('action')->middleware('login');
//メッセージ取得
Route::get('ajax/get_message', 'AxiosController@get_message')->name('get_message');
//////////////////////////////////////////////////////////////////////////////



/////////////////////////////////////食材一覧＆詳細/////////////////////////////////////////
Route::get('/foods_show', 'MyFoodsController@foods_show')->name('foods_show')->middleware('login');
Route::get('/item_list/{id}', 'MyFoodsController@item_list')->name('item_list')->middleware('login');
Route::get('/item_detail/{id}', 'MyFoodsController@item_detail')->name('item_detail')->middleware('login');
Route::get('/item_list/search/{id}/{val}', 'AxiosController@search_food')->name('search_food');
//////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////食材編集/////////////////////////////////////////
Route::get('/item_edit/{id}', 'MyFoodsController@food_edit_show')->name('item_edit_show')->middleware('login');
Route::post('/item_edit/{id}', 'RegisterController@food_edit')->name('food_edit')->middleware('login');

//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////マイページ////////////////////////////////////////////
Route::get('/mypage', 'MyFoodsController@mypage_show')->name('mypage')->middleware('login');
Route::get('/ajax/get_all/{id}', 'AxiosController@get_all')->name('get_all');
Route::get('/ajax/get_like/{id}', 'AxiosController@get_like')->name('get_like');
Route::get('/ajax/re_like/{id}', 'AxiosController@re_like')->name('re_like');
Route::get('/ajax/get_decision/{id}', 'AxiosController@get_decision')->name('get_decision');
Route::post('/ajax/delete_food/{id}', 'AxiosController@delete_food')->name('delete_food');

///////////////////////////////////paging///////////////////////////////////////////


///////////////////////////////////相手の登録食材///////////////////////////////////////////
Route::get('/pertner/{id}', 'MyFoodsController@pertner_show')->name('pertner')->middleware('login');




/////////////////////////////////////いいね処理/////////////////////////////////////////
Route::get('/foods/{food}/check', 'MyFoodsController@check')->name('like.check');
Route::post('/item_detail/{id}', 'AxiosController@store')->name('like.add');
//いいねリスト
Route::get('/like_list/{id}', 'MyFoodsController@like_list')->name('like_list');
Route::get('/get_store', 'AxiosController@get_store')->name('get_store');
//////////////////////////////////////////////////////////////////////////////


///////////////////////////////////////チャット画面///////////////////////////////////////
Route::get('/item_detail/{id}/{kind}/chat', 'ChatController@chat')->name('chat');
Route::post('/item_detail/{id}/{kind}/chat', 'Ajax\ChatRoomController@create')->name('chat.send');
Route::get('ajax/item_detail/{id}/{kind}/chat', 'Ajax\ChatRoomController@index')->name('chat.index');
//チャットリスト
Route::get('/item_detail/{id}/chatlist', 'ChatController@chatlist')->name('chat.list');
Route::get('/all_chat', 'ChatController@all_list')->name('all_list');
Route::get('/all_reserve_list', 'ChatController@all_reserve_list')->name('all_reserve_list');
Route::get('/all_send_list', 'ChatController@all_send_list')->name('all_send_list');
//////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////ユーザー詳細画面/////////////////////////////////
Route::get('/user_detail/{id}', 'MyFoodsController@user_detail')->name('user_detail');

//////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////プロフィール編集///////////////////////////////////////
Route::get('/prof_edit', 'MyFoodsController@prof_edit_view')->name('prof_show');
Route::get('/get_post', 'AxiosController@get_post')->name('get_post');
Route::get('/uniqe_edit', 'MyFoodsController@uniqe_edit_view')->name('uniqe_show');
Route::post('/uniqe_edit', 'RegisterController@uniqe_edit')->name('uniqe_edit');
Route::post('/prof_edit', 'RegisterController@prof_edit')->name('prof_edit');



//////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////成約成立処理///////////////////////////////////////
Route::post('/push_decision/{food_id}', 'AxiosController@decision')->name('decision');

/////////////////////////////////////////利用規約など/////////////////////////////////////////////

Route::get('/about', 'MyFoodsController@about')->name('about');
Route::get('/rule', 'MyFoodsController@rule')->name('rule');
Route::get('/privacy', 'MyFoodsController@privacy')->name('privacy');
Route::get('/legal', 'MyFoodsController@legal')->name('legal');

/////////////////////////////////////////お問い合わせフォーム/////////////////////////////////////////////
Route::get('/contact', 'MyFoodsController@contact')->name('contact');
Route::post('/contact', 'MyFoodsController@sendmail')->name('sendmail');


/////////////////////////////////////郵便番号検索/////////////////////////////////////////
Route::get('/ajax/postal_search', 'Ajax\PostalCodeController@search');
Route::get('postal_code', 'HomeController@postal_code');
Auth::routes([
    'register' => false ,
    'login' => false,
]);


//=========================退会==============================
Route::get('/withdrawal', 'RegisterController@withdrawal')->name('withdrawal');
Route::post('/withdrawal', 'RegisterController@drawal')->name('drawal');

//=======================================================
//////////////////////////////////////////////////////////////////////////////
//========================excelインポート===============================
Route::get('/excel', 'RegisterController@excel')->name('excel');
Route::post('/import', 'RegisterController@import')->name('import');
//=======================================================