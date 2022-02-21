<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IdentityProvider extends Model
{
    protected $fillable = ['store_id', 'provider_name', 'provider_id'];
    protected $primaryKey = 'store_id';
    function store()
    {
        return $this->belongsTo(Store::class);
    }
}
