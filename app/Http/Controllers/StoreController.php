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
        $this->middleware('auth:api');

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

            $response = new ApiResponse(0, trans('messages.success'), [], 201);
        } catch (\Exception $e) {
            $errorMessage = $this->showErrors == true ? $e->getMessage() : trans('messages.failure');

            $response = new ApiResponse(-1, $errorMessage, [], 500);
        }

        return $response->toJson();
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $store = Store::findOrFail($id);

            $response = new ApiResponse(0, trans('messages.success'), $store->toArray());
        } catch (\Exception $e) {
            $errorMessage = $this->showErrors == true ? $e->getMessage() : trans('messages.failure');

            $response = new ApiResponse(-1, $errorMessage, [], 500);
        }

        return $response->toJson();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreRequest $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(StoreRequest $request, $id)
    {
        $input = $request->all();

        try {
            $store = Store::findOrFail($id);

            $this->service->update($input, $store);

            $response = new ApiResponse(0, trans('messages.success'), [], 201);
        } catch (\Exception $e) {
            $errorMessage = $this->showErrors == true ? $e->getMessage() : trans('messages.failure');

            $response = new ApiResponse(-1, $errorMessage, [], 500);
        }

        return $response->toJson();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $store = Store::findOrFail($id);

            $store->delete();

            $response = new ApiResponse(0, trans('messages.success'), []);
        } catch (\Exception $e) {
            $errorMessage = $this->showErrors == true ? $e->getMessage() : trans('messages.failure');

            $response = new ApiResponse(-1, $errorMessage, [], 500);
        }

        return $response->toJson();
    }

}
