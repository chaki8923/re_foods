<?php

namespace App\Http\Controllers;

use App\Address;
use App\Food;
use App\Message;
use App\Store;
use App\Http\Requests\MyVaridation;
use App\Http\Requests\FoodValidation;
use App\Http\Requests\EditValidate;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
use Illuminate\Foundation\Console\Presets\React;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


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
    public function food_edit(FoodValidation $request,$id)
    {


        $food = Food::find($id);
        Log::debug($food);
        if ($request->file('pic1')) {
            
            Storage::disk('public')->delete('images/' . $food->pic1);
            $file1 = $request->file('pic1');
            $name1 = $file1->getClientOriginalName();
            Image::make($file1)->resize(600, null,
            function ($constraint) {
              // 縦横比を保持したままにする
              $constraint->aspectRatio();
              // 小さい画像は大きくしない
              $constraint->upsize();
            }
        )->save(public_path('storage/images/'.$name1));
          

          // 保存する
            $food->pic1 = $name1;
        }
        
        if ($request->file('pic2')) {
            Storage::disk('public')->delete('images/' . $food->pic2);
            $file2 = $request->file('pic2');
            $name2 = $file2->getClientOriginalName();
            Image::make($file2)->resize(600, null,
            function ($constraint) {
              // 縦横比を保持したままにする
              $constraint->aspectRatio();
              // 小さい画像は大きくしない
              $constraint->upsize();
            }
        )->save(public_path('storage/images/'.$name2));
          

          // 保存する
            $food->pic2 = $name2;
        }
        if ($request->file('pic3')) {
            
            Storage::disk('public')->delete('images/' . $food->pic3);
            $file3 = $request->file('pic3');
            $name3 = $file3->getClientOriginalName();
            Image::make($file3)->resize(600, null,
            function ($constraint) {
              // 縦横比を保持したままにする
              $constraint->aspectRatio();
              // 小さい画像は大きくしない
              $constraint->upsize();
            }
        )->save(public_path('storage/images/'.$name3));
          

          // 保存する
            $food->pic3 = $name3;
        }


        $food->store_id = session()->get('id');
        $food->fill($request->all())->save();
        return redirect()->route('action', session()->get('id'))->with('flash_message', __('FOOD_EDIT'));
    }
    //=======================食材登録================================
    //
    public function food_regist(FoodValidation $request)
    {

        $food = new Food;
        if ($request->file('pic1')) {

            $file1 = $request->file('pic1');
            $name1 = $file1->getClientOriginalName();
            Image::make($file1)->resize(600, null,
            function ($constraint) {
              // 縦横比を保持したままにする
              $constraint->aspectRatio();
              // 小さい画像は大きくしない
              $constraint->upsize();
            }
        )->save(public_path('storage/images/'.$name1));
          

          // 保存する
            $food->pic1 = $name1;
        }
        
        if ($request->file('pic2')) {
            $file2 = $request->file('pic2');
            $name2 = $file2->getClientOriginalName();
            Image::make($file2)->resize(600, null,
            function ($constraint) {
              // 縦横比を保持したままにする
              $constraint->aspectRatio();
              // 小さい画像は大きくしない
              $constraint->upsize();
            }
        )->save(public_path('storage/images/'.$name2));
          

          // 保存する
            $food->pic2 = $name2;
        }
        if ($request->file('pic3')) {

            $file3 = $request->file('pic3');
            $name3 = $file3->getClientOriginalName();
            Image::make($file3)->resize(600, null,
            function ($constraint) {
              // 縦横比を保持したままにする
              $constraint->aspectRatio();
              // 小さい画像は大きくしない
              $constraint->upsize();
            }
        )->save(public_path('storage/images/'.$name3));
          

          // 保存する
            $food->pic3 = $name3;
        }

        
        $food->store_id = session()->get('id');
        $food->fill($request->all())->save();
        return redirect()->route('action', session()->get('id'))->with('flash_message', __('FOOD_REGISTER'));
    }
    //=======================会員情報変更================================
    
    public function prof_edit(MyVaridation $request)
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
        }else{
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

}
