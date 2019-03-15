<?php
/**
 * Created by PhpStorm.
 * User: armin
 * Date: 3/14/19
 * Time: 11:11 AM
 */

namespace App\Services;

use App\Store;

class Stores
{

    /**
     * @return mixed
     */
    public function getAll()
    {
        return Store::latest()->get()->toArray();
    }

    /**
     * @param array $input
     * @return mixed
     */
    public function create(array $input)
    {
        return Store::create($input);
    }

    /**
     * @param array $input
     * @param Store $store
     * @return bool
     */
    public function update(array $input,Store $store)
    {
        return $store->update($input);
    }

    /**
     * @param $latitude
     * @param $longitude
     * @param $distance
     * @return mixed
     */
    public static function getNearby($latitude, $longitude, $distance)
    {
        // Raw query to select products offered by stores
        // within specific miles from buyer's location
        return \DB::select("SELECT products.*, ( 3959 * acos( cos( radians($latitude) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( latitude ) ) ) ) AS distance FROM stores,products where products.store_id = stores.id HAVING distance < $distance ORDER BY distance;");
    }

}