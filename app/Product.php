<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * @param $id
     * @param $quantity
     * @return bool
     */
    public static function haveQuantity($id, $quantity)
    {
        return (bool)self::whereId($id)->where('quantity','>=', $quantity)->get()->count() > 0;
    }

    /**
     * @param $id
     * @param $quantity
     * @return bool
     */
    public static function takeQuantity($id, $quantity)
    {
        $product = self::findOrFail($id);

        $product->quantity -= $quantity;

        return (bool)$product->save();
    }
}
