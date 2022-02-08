<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';
    protected $fillable = ['place','prefecture','city','address','first_code','last_code'];

    public function store(){
        return $this->belongsTo('App\Store');
    }
}
