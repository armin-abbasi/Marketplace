<?php

namespace App\Http\Controllers;

use App\Product;
use App\Services\Products;
use App\Services\Response\ApiResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    /**
     * @var Products $service
     */
    private $service;

    /**
     * @var $showErrors
     */
    private $showErrors;

    public function __construct()
    {
        $this->middleware('auth:api');

        $this->service = new Products();

        $this->showErrors = env('APP_DEBUG', false) == true ? true : false;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->service->getAll();

        $response = new ApiResponse(-1, trans('messages.no-data'), []);

        if (count($products) > 0) {
            $response = new ApiResponse(0, trans('messages.success'), $products);
        }

        return $response->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        try {
            $this->service->create($input);

            $response = new ApiResponse(0, trans('messages.success'), [], 201);
        } catch (\Exception $e) {
            $errorMessage = $this->showErrors == true ? $e->getMessage() : trans('failure');

            $response = new ApiResponse(-1, $errorMessage, [], 500);
        }

        return $response->toJson();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $product = Product::findOrFail($id);

            $response = new ApiResponse(0, trans('messages.success'), $product->toArray());
        } catch (\Exception $e) {
            $errorMessage = $this->showErrors == true ? $e->getMessage() : trans('failure');

            $response = new ApiResponse(-1, $errorMessage, [], 500);
        }

        return $response->toJson();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        try {
            $result = $this->service->update($input, $id);

            $errorMessage = ($result !== true) ? 'Not authorized or no data to access' : trans('messages.success');

            $response = new ApiResponse(0, $errorMessage, [], 201);
        } catch (\Exception $e) {
            $errorMessage = $this->showErrors == true ? $e->getMessage() : trans('failure');

            $response = new ApiResponse(-1, $errorMessage, [], 500);
        }

        return $response->toJson();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $result = $this->service->delete($id);

            $errorMessage = ($result !== true) ? 'Not authorized or no data to access' : trans('messages.success');

            $response = new ApiResponse(0, $errorMessage, [], 201);
        } catch (\Exception $e) {
            $errorMessage = $this->showErrors == true ? $e->getMessage() : trans('failure');

            $response = new ApiResponse(-1, $errorMessage, [], 500);
        }

        return $response->toJson();
    }
}
