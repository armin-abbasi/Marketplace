<?php
/**
 * Created by PhpStorm.
 * User: armin
 * Date: 3/13/19
 * Time: 10:18 PM
 */

namespace App\Services\Response;


class ApiResponse
{

    /**
     * @var integer $responseCode
     */
    public $responseCode;

    /**
     * @var string $responseMessage
     */
    public $responseMessage;

    /**
     * @var array $data
     */
    public $data;

    /**
     * @var integer $status
     */
    public $status;

    /**
     * ApiResponse constructor.
     * @param $responseCode
     * @param $responseMessage
     * @param $data
     * @param int $status
     */
    public function __construct($responseCode, $responseMessage, $data, $status = 200)
    {
        $this->responseCode = $responseCode;
        $this->responseMessage = $responseMessage;
        $this->data = $data;
        $this->status = $status;
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function toJson()
    {
        return response([
            'responseCode' => $this->responseCode,
            'responseMessage' => $this->responseMessage,
            'data' => $this->data,
        ], $this->status);
    }

}