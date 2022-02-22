<?php

namespace App\Http\Controllers;

use App\Address;
use App\Food;
use App\Message;
use App\Store;
use App\Http\Requests\MyVaridation;
use App\Http\Requests\FoodValidation;
use App\Http\Requests\EditValidate;
use App\Http\Requests\ProfEditValidation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\SampleNotification;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Imports\ExcelImport;
use App\IdentityProvider;
use App\Like;
use App\PassReset;
use Maatwebsite\Excel\Facades\Excel;
use PHPUnit\Framework\MockObject\Builder\Identity;

class RegisterController extends Controller
{

  //=======================新規登録処理================================
  public function register(MyVaridation $request)
  {

    $filename = basename($request->file('image'));


    $address = new Address;
    $store = new Store;

    $imagePath = '/images/ ' . $filename . '.jpeg';

    if ($filename) {
      $cropImageData = base64_decode(explode(",", explode(";", $request->cropImage)[1])[1]);
      $storageImagePath = storage_path('app/public') . $imagePath;
      file_put_contents($storageImagePath, $cropImageData);
    }

    $publicImagePath = '/storage' . $imagePath;
    $store->fill([
      'store_name' => $request->store_name,
      'email' => $request->email,
      'password' => Hash::make($request['password']),
      'tell_number' => $request->tell_number,
      'store_image' => $publicImagePath
    ])->save();


    $address->store_id = $store->id;
    $address->fill($request->all())->save();

    session(['store_name' => $store->store_name]);
    session(['email' => $store->email]);
    session(['id' => $store->id]);
    return redirect()->route('action', $store->id);
  }
  //=======================================================
  //=======================食材編集================================
  //
  public function food_edit(FoodValidation $request, $id)
  {


    $food = Food::find($id);
    Log::debug($food);
    if ($request->file('pic1')) {

      Storage::disk('public')->delete('images/' . $food->pic1);
      $file1 = $request->file('pic1');
      $name1 = $file1->getClientOriginalName();
      Image::make($file1)->resize(
        600,
        null,
        function ($constraint) {
          // 縦横比を保持したままにする
          $constraint->aspectRatio();
          // 小さい画像は大きくしない
          $constraint->upsize();
        }
      )->save(public_path('storage/images/' . $name1));


      // 保存する
      $food->pic1 = $name1;
    }

    if ($request->file('pic2')) {
      Storage::disk('public')->delete('images/' . $food->pic2);
      $file2 = $request->file('pic2');
      $name2 = $file2->getClientOriginalName();
      Image::make($file2)->resize(
        600,
        null,
        function ($constraint) {
          // 縦横比を保持したままにする
          $constraint->aspectRatio();
          // 小さい画像は大きくしない
          $constraint->upsize();
        }
      )->save(public_path('storage/images/' . $name2));


      // 保存する
      $food->pic2 = $name2;
    }
    if ($request->file('pic3')) {

      Storage::disk('public')->delete('images/' . $food->pic3);
      $file3 = $request->file('pic3');
      $name3 = $file3->getClientOriginalName();
      Image::make($file3)->resize(
        600,
        null,
        function ($constraint) {
          // 縦横比を保持したままにする
          $constraint->aspectRatio();
          // 小さい画像は大きくしない
          $constraint->upsize();
        }
      )->save(public_path('storage/images/' . $name3));


      // 保存する
      $food->pic3 = $name3;
    }


    $food->store_id = session()->get('id');
    $food->fill($request->all())->save();
    return redirect()->route('action', session()->get('id'))->with('flash_message', __('FOOD_EDIT'));
  }





  //=======================食材登録================================



  public function food_regist(FoodValidation $request)
  {
    $address = Address::where('store_id', session()->get('id'))->first();

    $food = new Food;
    if ($request->file('pic1')) {

      $file1 = $request->file('pic1');
      $name1 = $file1->getClientOriginalName();
      Image::make($file1)->resize(
        600,
        null,
        function ($constraint) {
          // 縦横比を保持したままにする
          $constraint->aspectRatio();
          // 小さい画像は大きくしない
          $constraint->upsize();
        }
      )->save(public_path('storage/images/' . $name1));


      // 保存する
      $food->pic1 = $name1;
    }

    if ($request->file('pic2')) {
      $file2 = $request->file('pic2');
      $name2 = $file2->getClientOriginalName();
      Image::make($file2)->resize(
        600,
        null,
        function ($constraint) {
          // 縦横比を保持したままにする
          $constraint->aspectRatio();
          // 小さい画像は大きくしない
          $constraint->upsize();
        }
      )->save(public_path('storage/images/' . $name2));


      // 保存する
      $food->pic2 = $name2;
    }
    if ($request->file('pic3')) {

      $file3 = $request->file('pic3');
      $name3 = $file3->getClientOriginalName();
      Image::make($file3)->resize(
        600,
        null,
        function ($constraint) {
          // 縦横比を保持したままにする
          $constraint->aspectRatio();
          // 小さい画像は大きくしない
          $constraint->upsize();
        }
      )->save(public_path('storage/images/' . $name3));


      // 保存する
      $food->pic3 = $name3;
    }


    $food->store_id = session()->get('id');
    $food->address = $address->address;
    $food->fill($request->all())->save();



    return redirect()->route('action', session()->get('id'))->with('flash_message', __('FOOD_REGISTER'));
  }
  //=======================会員情報変更================================

  public function prof_edit(ProfEditValidation $request)
  {

    $id = session()->get('id');
    $store = Store::find($id);
    $address = Address::where('store_id', $store->id)->first();

    $filename = basename($request->file('image'));
    $imagePath = '/images/ ' . $filename . '.jpeg';

    if ($filename) {
      $cropImageData = base64_decode(explode(",", explode(";", $request->cropImage)[1])[1]);
      $storageImagePath = storage_path('app/public') . $imagePath;
      file_put_contents($storageImagePath, $cropImageData);
    }

    $publicImagePath = '/storage' . $imagePath;

    $store->fill([
      'store_name' => $request->store_name,
      'email' => $request->email,
      'password' => Hash::make($request['password']),
      'tell_number' => $request->tell_number,
      'store_image' => $publicImagePath
    ])->save();

    $address->store_id = $store->id;
    $address->fill($request->all())->save();

    session(['store_name' => $store->store_name]);
    session(['email' => $store->email]);
    session(['id' => $store->id]);
    return redirect()->route('action', $store->id);
  }
  //=======================簡単情報変更================================

  public function uniqe_edit(EditValidate $request)
  {
    $id = session()->get('id');
    $store = Store::find($id);

    $filename = basename($request->file('image'));
    $imagePath = '/images/ ' . $filename . '.jpeg';

    if ($filename) {
      $cropImageData = base64_decode(explode(",", explode(";", $request->cropImage)[1])[1]);
      $storageImagePath = storage_path('app/public') . $imagePath;
      file_put_contents($storageImagePath, $cropImageData);
      $publicImagePath = '/storage' . $imagePath;
    } else {
      $publicImagePath = $store->store_image;
    }



    $store->fill([
      'store_name' => $request->store_name,
      'comment' => $request->comment,
      'store_image' => $publicImagePath
    ])->save();
    $store = Store::find($id);
    session(['store_name' => $store->store_name]);

    return redirect()->route('action', $store->id);
  }

  //=======================パスワードリセット================================
  public function forget()
  {

    return view('foods.forget_pass');
  }
  public function reset()
  {
    $now = new Carbon('now');
    Log::debug('今' . $now);
    Log::debug('期限' . session()->get('limit'));
    if ($now->gt(session()->get('limit'))) {
      Log::debug('期限切れ');
      return redirect()->route('forget')->with('flash_message', __('ワンタイムパスの期限切れです'));
    } else {

      Log::debug('まだ大丈夫');
    }
    return view('foods.reset_pass');
  }

  public function forget_mail()
  {

    $store = Store::select('*')->where('email', request()->input('email'))->first();
    $pass = new PassReset;
    $limit = new Carbon('+15 minutes');
    session(['limit' => $limit]);
    if ($store) {

      $token = mt_rand(1, 10);
      for ($i = 0; $i < 7; $i++) {
        $token .= mt_rand(1, 10);
      }
      $pass->token = $token;
      session(['token_id' => $token]);
      session(['id' => $store->id]);

      $name = $store->store_name;
      $text = $token;
      Log::debug('token' . $text);
      $to = request()->input('email');
      Mail::to($to)->send(new SampleNotification($name, $text));

      return redirect()->route('reset')->with('flash_message', __('ワンタイムパスを送信しました。'));
    } else {
      return redirect()->route('forget')->with('flash_message', __('登録されていないアドレスです'));
    }
  }
  public function reset_mail()
  {

    $now = new Carbon('now');
    if ($now->gt(session()->get('limit'))) {
      return redirect()->route('forget')->with('flash_message', __('ワンタイムパスの期限切れです'));
    }
    $store = Store::find(session()->get('id'));
    $pass = session()->get('token_id');
    session(['store_name' => $store->store_name]);
    Log::debug('トークン' . $pass);
    //入力内容がメールに記載のトークンと合っていてかつ再入力とも合っていたら
    if ($pass == request()->input('password') && request()->input('password') == request()->input('password_confirmation')) {

      Log::debug('旧' . $store->password);
      $store->password = $pass;
      Log::debug('新' . $pass);
      return redirect()->route('action', $store->id)->with('flash_message', __('ログインしました。'));
    } else {

      return back()->with('flash_message', __('入力内容に誤りがあります。'));
    }
  }

  //==========================退会=============================

  public function withdrawal()
  {

    return view('foods.withdrawal');
  }
  public function drawal()
  {

    $id = session()->get('id');
    $account = IdentityProvider::where('store_id',$id)->first();
    if($account->store_id){
      $account->delete();
    }
    $store = Store::find($id);
    $foods = Food::where('store_id', $store->id)->get();
    foreach ($foods as $val) {
      if ($val->pic1) {
        
        Storage::disk('public')->delete('images/' . $val->pic1);
      }
      if ($val->pic2) {
        
        Storage::disk('public')->delete('images/' . $val->pic2);
      }
      if ($val->pic3) {
        
        Storage::disk('public')->delete('images/' . $val->pic3);
      }
      
      Like::where('food_id', $val->id)->where('store_id', $id)->delete();
      Message::where('food_id', $val->id)->delete();
      $val->delete();
    }
    $store->delete();
    session()->flush();
    return redirect()->route('top_page');
  }

  //========================excxel===============================
  public function excel()
  {

    return view('foods.excel');
  }
  public function import()
  {
    Excel::import(new ExcelImport, request()->file('file'));
    return back();
  }
  //=======================================================
}
