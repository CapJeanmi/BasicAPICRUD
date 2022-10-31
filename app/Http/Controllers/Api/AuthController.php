<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends ApiController
{
    /* Función para Login, en caso de ser exitosa la petición después de su validación. 
    Responderá con el IP del usuario como fue requerido */

    public function login(Request $request)
    {
        try {
            Log::info("Petición de login. IP: " . $request->ip());
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->serverError($validator->errors());
            }

            /* Validaciones y Requerimientos especiales en la creación del TOKEN */

            if (auth()->attempt($request->only('email', 'password'))) {
                $now = new \DateTime();
                $content = auth()->user()->email . $now->format('Y-m-d H:i:s') . rand(200, 500);
                $data['access_token'] = auth()->user()->createToken($content)->plainTextToken;
                $data['token_type'] = 'Bearer';

                /* Respuesta del servidor y su impresión en LOGS */

                if (env('APP_DEBUG') === true) {
                    Log::info("Petición de login exitosa. IP: " . $request->ip());
                }
                return $this->success($data, "Bienvenido");
            }

            return $this->serverError("Credenciales incorrectas");
        } catch (Exception $ex) {
            Log::error($ex);
            return $this->serverError($ex->getMessage());
        }
    }
}
