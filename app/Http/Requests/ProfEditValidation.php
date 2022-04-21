<?php

namespace App\Http\Requests;



use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfEditValidation extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'store_name'=>'required',
            'email'=>['required','email','max:255',Rule::unique('stores')->ignore($request->store_id,'id')],
            'first_code' => 'required|max:3',
            'last_code' => 'required|max:4',
            'prefecture' => 'required|max:255',
            'city' => 'required|max:255',
            'address' => 'required|max:255',
            'place' => 'max:255',
            'password'=>'nullable|min:4|confirmed',
            'store_image'=>'max:3000|string|nullable|mimes:jpeg,png,jpg,gif',
            'message'=>'string|max:255',
     
     
        
        ];
    }

    public function messages()
    {
        return[
            'name.max'=>'文字数オーバーです',
            'email.email'=>'emailの形式と異なります',
            'email.unique'=>'すでに登録されているアドレスです。',
            'password.min'=>'6文字以上で入力してください。',
            'password.confirmed'=>'再入力と一致しません。',
            'message.max'=>'文字数オーバーです。',
            'store_image.max'=>'10Mバイト以上は登録できません。',
            'store_image.mimes'=>'画像形式に問題があります。',

            
        ];
        
    }
}
