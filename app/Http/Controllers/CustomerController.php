<?php

namespace App\Http\Controllers;

use App\Services\Customers;
use App\Services\Response\ApiResponse;

class CustomerController extends Controller
{

    /**
     * @var Customers $service
     */
    private $service;

    /**
     * @var $showErrors
     */
    private $showErrors;

    public function __construct()
    {
        $this->middleware('auth:api');

        $this->service = new Customers();

        $this->showErrors = env('APP_DEBUG', false) == true ? true : false;
    }

    public function listProducts()
    {
        try {
            $products = $this->service->listProducts();

            $response = new ApiResponse(-1, trans('messages.no-data'), []);

            if (count($products) > 0) {
                $response = new ApiResponse(0, trans('messages.success'), $products);
            }
        } catch (\Exception $e) {
            $errorMessage = $this->showErrors == true ? $e->getMessage() : trans('messages.failure');

            $response = new ApiResponse(-1, $errorMessage, [], 500);
        }

        return $response->toJson();
    }
}
