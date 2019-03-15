<?php
/**
 * Created by PhpStorm.
 * User: armin
 * Date: 3/15/19
 * Time: 9:43 AM
 */

namespace App\Services;


use App\User;
use Illuminate\Support\Facades\Auth;

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

    public function listProducts()
    {
        return Stores::getNearby($this->customer->latitude, $this->customer->longitude);
    }

}