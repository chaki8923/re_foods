<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
    public function rules()
    {
        return [
            'store_name'=>'required',
            'email'=>'required|email|max:255',
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
}
