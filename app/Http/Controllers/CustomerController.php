<?php

namespace App\Http\Controllers;

use App\Http\Requests\BuyProductRequest;
use App\Services\Customers;
use App\Services\Response\ApiResponse;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

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

    public function buyProduct(BuyProductRequest $request)
    {
        $input = $request->all();

        try {
            $data = $this->service->buyProduct($input);

            $message = empty($data) ? trans('messages.failure_purchase') : trans('messages.success_purchase');

            $response = new ApiResponse(0, $message, $data, 200);
        } catch (NotFoundResourceException $e) {
            $response = new ApiResponse(-2, $e->getMessage(), [], 200);
        } catch (\Exception $e) {
            $errorMessage = $this->showErrors == true ? $e->getMessage() : trans('messages.failure_purchase');

            $response = new ApiResponse(-1, $errorMessage, [], 500);
        }

        return $response->toJson();
    }
}
