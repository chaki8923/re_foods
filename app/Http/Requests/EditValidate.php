<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditValidate extends FormRequest
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
            'comment'=>'string|required|max:255',
     
     
        
        ];
    }

    public function messages()
    {
        return[
            'store_name.required'=>'名前は必須です。',
            'comment.strung'=>'文字列で入力して下さい。',
            'comment.required'=>'自己紹介を登録してみよう！',
            'comment.max:255'=>'文字数オーバーです。',
            
        ];
        
    }
}
