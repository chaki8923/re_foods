<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'foods';
    protected $fillable = ['food_name', 'store_id', 'loss_limit', 'plice', 'category_id','sub_category_id','comment','decision_at'];

    protected $dates = [
     
        'updated_at'
    ];

    // protected $primaryKey = 'store_id';
    public function store()
    {

        return $this->belongsTo('App\Store');
    }

    public function category()
    {
        return $this->hasMany('App\Like');
    }
    public function likes()
    {
        return $this->belongsTo('App\Category');
    }

    public function isLiked($store_id)
    {
        return $this->likes->where('store_id', $store_id)->exists();
    }
}
