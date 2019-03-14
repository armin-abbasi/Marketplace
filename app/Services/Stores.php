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
        $stores = Store::latest()->get()->toArray();

        return $stores;
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

}