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
          
            'password'=>'required|min:4|confirmed',
          
            
            
        ];
    }
    public function messages()
    {
        return[
            'store_name.required'=>'店舗名は入力必須です',
            'email.required'=>'emailは入力必須です',
            'email.email'=>'emailの形式と異なります',
          
            'password.required'=>'パスワードは入力必須です。',
            'password.min8'=>'8文字以上で入力してください。',
            'password.confirmed'=>'再入力と一致しません。',
          
        ];
        
    }
}
