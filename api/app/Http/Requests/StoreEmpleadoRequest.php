<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreEmpleadoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'primer_apellido' => 'required|regex:/^[A-Z][a-z]{1,20}$/',
            'segundo_apellido' => 'required|regex:/^[A-Z][a-z]{1,20}$/',
            'primer_nombre' => 'required|regex:/^[A-Z][a-z]{1,20}$/',
            'otros_nombres' => 'nullable|regex:/^[A-Z ][a-z]{1,50}$/',
            'pais_del_empleo' => 'required|in:Colombia,Estados Unidos',
            'tipo_de_identificacion' => 'required|in:Cédula de Ciudadanía,Cédula de Extranjería,Pasaporte,Permiso Especial',
            'numero_de_identificacion' => 'required|alpha_dash|max:20|unique:empleados,numero_de_identificacion',
            'fecha_de_ingreso' => 'required|date|before_or_equal:today|after_or_equal:' . now()->subMonth()->toDateString(),
            'area' => 'required|in:Administración,Financiera,Compras,Infraestructura,Operación,Talento Humano,Servicios Varios'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Error de validación',
            'data' => $validator->errors()
        ]));
    }
}
