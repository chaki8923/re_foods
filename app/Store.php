<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{

    protected $table = 'stores';
    protected $fillable =['store_name','email','add_id','post_number','tell_number','store_image','password','last_accessed_at','comment'];

    protected $dates = [
    
        'updated_at'
    ];

    public function foods(){
        return $this->hasMany('App\Food');

    
    }
    public function messages(){
        return $this->belongsTo('App\Message','from_store');
    }

    protected $appends = [
        'is_online' // ここを追加しました
    ];
    

    public function getIsOnlineAttribute() { // ここを追加しました

        $last_accessed_at = $this->last_accessed_at;
    
        return (
            !is_null($last_accessed_at) &&
            now()->diffInMinutes($last_accessed_at) <= 15 // 最終アクセスが15分以内の場合
        );
    
    }

    function IdentityProviders()
    {
        // IdentityProviderモデルと紐付ける 1対多の関係
        return $this->hasMany(IdentityProvider::class);
    }

}

