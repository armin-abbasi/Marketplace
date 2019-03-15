<?php
/**
 * Created by PhpStorm.
 * User: armin
 * Date: 3/15/19
 * Time: 9:43 AM
 */

namespace App\Services;


use App\Product;
use App\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class Customers
{

    /**
     * @var User $customer
     */
    private $customer;

    public function __construct()
    {
        $this->customer = Auth::user();
    }

    /**
     * Find products from nearby stores
     * @return mixed
     */
    public function listProducts()
    {
        return Stores::getNearby($this->customer->latitude, $this->customer->longitude, 10);
    }

    /**
     * @param $input
     * @return array
     */
    public function buyProduct($input)
    {
        $productId = $input['id'];
        $quantity = $input['quantity'];
        $data = [];

        if (! Product::haveQuantity($productId, $quantity)) {
            throw new NotFoundResourceException("Not enough products in inventory");
        }

        if (Product::takeQuantity($productId, $quantity)) {
            $purchase = $this->customer->purchases()->create([
                'product_id' => $productId,
                'quantity' => $quantity
            ]);

            $data['purchase_id'] = $purchase['id'];
        }

        return $data;

    }

}