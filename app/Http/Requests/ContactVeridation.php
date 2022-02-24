<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class ContactVeridation extends FormRequest
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
        Log::debug('ばりで');
        return [
            'store_name'=>'required',
            'email'=>'required|email',
            'message'=>'string|max:255',
        ];
        Log::debug('ばりで後ろ');
    }
    
    public function messages()
    {
        Log::debug('ばりで2');
        return[
            'store_name.required'=>'名前は必須です。',
            'email.required'=>'Emailは必須です',
            'email.email'=>'形式が異なります',
            'message.string'=>'文字を入力してください',
            'message.max:255'=>'文字数オーバーです。',
            
        ];
        Log::debug('ばりで後ろ2');
        
    }
}
