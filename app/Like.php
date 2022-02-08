<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable =['store_id','to_store','food_id','new_flg'];

    public function store(){
        return $this->belongsTo('App\Store');
    }
    public function foods(){
        return $this->belongsTo('App\Food');
    }
}
