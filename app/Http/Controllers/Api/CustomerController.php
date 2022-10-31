<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;

class CustomerController extends ApiController
{
    public function index(Request $request)
    {
        /* Consulta a la Base de Datos en la Tabla Customer, con su respectiva respuesta y validaciones
           Filtrando por email, dni y validando que usuarios estén Activos */
        try {
            Log::info("Petición de listado de clientes. IP: " . $request->ip());
            $customers = Customer::select("customers.*", "regions.description as region", "communes.description as commune")
                ->where('customers.status', "A")
                ->join("regions", "id_reg", "regions.id")
                ->join("communes", "id_com", "communes.id")
                ->when($request->email, function ($query) use ($request) {
                    return $query->where('customers.email', $request->email);
                })
                ->when($request->dni, function ($query) use ($request) {
                    return $query->where('customers.dni', $request->dni);
                })
                ->get();

            /* Respuesta del servidor a la consulta y su impresión en LOGS */

            if (env('APP_DEBUG') === true) {
                Log::info("Petición de listado de clientes exitosa. IP: " . $request->ip());
            }
            return $this->success($customers, "Resultados obtenidos");
        } catch (Exception $ex) {
            Log::error($ex);
            return $this->serverError($ex->getMessage());
        }
    }

    /* Creación de Customers con sus respectivas validaciones */
    public function store(Request $request)
    {
        try {
            Log::info("Petición de creación de cliente. IP: " . $request->ip());
            $validator = Validator::make($request->all(), [
                'dni' => 'required|numeric|unique:customers',
                'id_reg' => 'required|numeric|exists:regions,id',
                'id_com' => 'required|numeric|exists:communes,id',
                'email' => 'required|email|unique:customers',
                'name' => 'required',
                'last_name' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->validationError($validator->errors());
            }

            $customer = Customer::create($request->all());

            /* Respuesta del servidor y su impresión en LOGS */

            if (env('APP_DEBUG') === true) {
                Log::info("Petición de creacion de cliente exitosa. IP: " . $request->ip());
            }
            return $this->success($customer, "Creado Exitosamente");
        } catch (Exception $ex) {
            Log::error($ex);
            return $this->serverError($ex->getMessage());
        }
    }

    /* Eliminación de Usuario con su respectivo cambio de status de A/I a Trash */

    public function delete(Request $request, $id)
    {
        try {
            Log::info("Petición de eliminación de cliente. IP: " . $request->ip());
            $customer = Customer::find($id);

            if (!$customer) {
                return $this->serverError("Registro no existe");
            }

            if ($customer->status == "Trash") {
                return $this->serverError("Registro no existe");
            }

            $customer->status = "Trash";
            $customer->save();

            /* Respuesta del servidor y su impresión en LOGS */

            if (env('APP_DEBUG') === true) {
                Log::info("Petición de eliminación de cliente exitosa. IP: " . $request->ip());
            }
            return $this->success($customer, "Registro eliminado");
        } catch (Exception $ex) {
            Log::error($ex);
            return $this->serverError($ex->getMessage());
        }
    }
}
