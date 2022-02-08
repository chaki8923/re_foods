<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class MyVaridation extends FormRequest
{
     /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'store_name'=>'required',
            'email'=>'required|email|max:255|unique:stores',
            'first_code' => 'required|max:3',
            'last_code' => 'required|max:4',
            'prefecture' => 'required|max:255',
            'city' => 'required|max:255',
            'address' => 'required|max:255',
            'place' => 'max:255',
            'password'=>'required|min:4|confirmed',
            'store_image'=>'max:3000|string|nullable|mimes:jpeg,png,jpg,gif',
            'message'=>'string|max:255',
            
            
        ];
    }
    public function messages()
    {
        return[
            'store_name.required'=>'店舗名は入力必須です',
            'email.required'=>'emailは入力必須です',
            'email.email'=>'emailの形式と異なります',
            'email.unique'=>'すでに登録されているアドレスです。',
            'tell_number.digits_between:10,11' => '電話番号の形式ではありません',
            'first-code.required' => '郵便番号を入力してください',
            'last-code.required' => '郵便番号を入力してください',
            'prefecture.required' => '入力必須項目です。',
            'city.required' => '入力必須項目です。',
            'address.required' => '入力必須項目です。',
            'password.required'=>'パスワードは入力必須です。',
            'password.min8'=>'8文字以上で入力してください。',
            'password.confirmed'=>'再入力と一致しません。',
            'message.max255'=>'255字以内でメッセージを送って下さい。',
            'store_image.mimes'=>'画像形式に問題があります。',
            'store_image.max3000'=>'3Mバイト以上は登録できません。'
        ];
        
    }
}
