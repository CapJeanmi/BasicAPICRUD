<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;


class ApiController extends Controller
{
    /* Controlador Padre para respuestas y código en común en todo el Desarrollo de la API */

    private function response($message, $statusCode = 200, $data = null)
    {
        $response = [
            'success' => in_array($statusCode, [
                Response::HTTP_OK
            ]),
            'message' => (config('app.debug') === false) ? __('Ha ocurrido un error inesperado') : $message,
            'data' => null,
        ];
        if (!is_null($data))
            $response['data'] = $data;

        return response()->json($response, $statusCode);
    }

    public function success($data = null, $message = 'ok',  $statusCode = null)
    {
        if (is_null($statusCode))
            $statusCode = Response::HTTP_OK;

        return $this->response($message, $statusCode, $data);
    }

    public function error($message, $statusCode = null, $data = null)
    {
        if (is_null($statusCode))
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

        return $this->response($message, $statusCode, $data);
    }

    public function validationError($message)
    {
        return $this->error($message, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function serverError($message)
    {
        return $this->error($message, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
