<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable =['body','from_store','to_store','food_id','new_flg','updated_at'];

    protected $dates = [
        'updated_at'
    ];
    public function board(){
        return $this->hasMany('App\Board');
    }
    public function stores(){
        return $this->belongsToMany('App\Store');
    }
}
