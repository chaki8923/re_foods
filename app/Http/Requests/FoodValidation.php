<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FoodValidation extends FormRequest
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
            'plice'=>'integer|required',
            'category_id'=>'integer|required',
            'loss_limit'=>'date|required|after:tomorrow',
            'pic1'=>'required|file|max:5000|mimes:jpeg,png,jpg,gif',
            'comment'=>'string|max:255|nullable',
            // 'pic2'=>'string|nullable',
            // 'pic3'=>'string|nullable',
        
        ];
    }

    public function messages()
    {
        return[
            'plice.required'=>'値段は必須です。',
            'plice.integer'=>'半角数字のみで入力して下さい。',
            'category_id.integer'=>'カテゴリーを選んで下さい。',
            'category_id.required'=>'カテゴリーを選んで下さい。',
            'loss_limit.required'=>'賞味期限は入力必須です。',
            'loss_limit.date'=>'日付を入力して下さい',
            'loss_limit.after'=>'賞味期限が当日以前のものは登録できません',
            'pic1.required'=>'最低一つ以上の写真を掲載してください。',
            'pic1.mimes'=>'画像形式に問題があります。',
            'pic1.max'=>'10Mバイト以上は登録できません',
            'comment.max255'=>'文字数オーバーです。',
        ];
        
    }
}
