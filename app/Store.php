<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $guarded = [];

    protected $hidden = ['updated_at'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
