<?php
/**
 * Created by PhpStorm.
 * User: armin
 * Date: 3/14/19
 * Time: 8:37 PM
 */

namespace App\Services;


use App\Product;
use App\User;
use Illuminate\Support\Facades\Auth;

class Products
{

    /**
     * @var User
     */
    private $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return Product::latest()->get()->toArray();
    }

    /**
     * @param array $input
     * @return mixed
     */
    public function create(array $input)
    {
        // Since store_id has a one to one relationship
        // with user's table, then it's going to be alright
        // to consider first() store the only one!
        $input['store_id'] = $this->user->store()->first()->id;

        return Product::create($input);
    }

    /**
     * @param array $input
     * @param $id
     * @return bool
     */
    public function update(array $input, $id)
    {
        $product = $this->user->products()->find($id);

        // Return -2 response if this product does not belong
        // to the authenticated user
        return empty($product) ? -2 : $product->update($input);
    }

    /**
     * @param $id
     * @return bool|int|null
     * @throws \Exception
     */
    public function delete($id)
    {
        $product = $this->user->products()->find($id);

        // Return -2 response if this product does not belong
        // to the authenticated user
        return empty($product) ? -2 : $product->delete();
    }

}