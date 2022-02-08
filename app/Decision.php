<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Decision extends Model
{
    protected $fillable =['store_id','to_store','food_id','click_flg'];

    public function store(){
        return $this->belongsTo('App\Store');
    }
    public function foods(){
        return $this->hasMany('App\Food');
    }
}
