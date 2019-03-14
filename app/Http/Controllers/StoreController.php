<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use App\Services\Response\ApiResponse;
use App\Services\Stores;
use App\Store;

class StoreController extends Controller
{

    /**
     * @var Stores Stores
     */
    private $service;

    /**
     * @var $showErrors
     */
    private $showErrors;

    public function __construct()
    {
        $this->service = new Stores();

        $this->showErrors = env('APP_DEBUG', false) == true ? true : false;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stores = $this->service->getAll();

        $response = new ApiResponse(-1, trans('messages.no-data'), []);

        if (count($stores) > 0) {
            $response = new ApiResponse(0, trans('messages.success'), $stores);
        }

        return $response->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $input = $request->all();

        try {
            $this->service->create($input);

            $response = new ApiResponse(0, trans('messages.success'), []);
        } catch (\Exception $e) {
            $errorMessage = $this->showErrors == true ? $e->getMessage() : trans('failure');

            $response = new ApiResponse(-1, $errorMessage, []);
        }

        return $response->toJson();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show(Store $store)
    {
        $response = new ApiResponse(0, trans('messages.success'), $store->toArray());

        return $response->toJson();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreRequest $request
     * @param  \App\Store $store
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(StoreRequest $request, Store $store)
    {
        $input = $request->all();

        try {
            $this->service->update($input, $store);

            $response = new ApiResponse(0, trans('messages.success'), []);
        } catch (\Exception $e) {
            $errorMessage = $this->showErrors == true ? $e->getMessage() : trans('failure');

            $response = new ApiResponse(-1, $errorMessage, []);
        }

        return $response->toJson();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy(Store $store)
    {
        try {
            $store->delete();

            $response = new ApiResponse(0, trans('messages.success'), []);
        } catch (\Exception $e) {
            $errorMessage = $this->showErrors == true ? $e->getMessage() : trans('failure');

            $response = new ApiResponse(-1, $errorMessage, []);
        }

        return $response->toJson();
    }
}
