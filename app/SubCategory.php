<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $guarded = ['id'];

    public function foods()
    {
        return $this->hasMany('App\Food');
    }
}
