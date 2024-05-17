<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateEmpleadoRequest extends FormRequest
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
            'primer_apellido' => 'nullable|regex:/^[A-Z][a-z]{1,20}$/',
            'segundo_apellido' => 'nullable|regex:/^[A-Z][a-z]{1,20}$/',
            'primer_nombre' => 'nullable|regex:/^[A-Z][a-z]{1,20}$/',
            'otros_nombres' => 'nullable|regex:/^[A-Z ][a-z]{1,50}$/',
            'pais_del_empleo' => 'nullable|in:Colombia,Estados Unidos',
            'tipo_de_identificacion' => 'nullable|in:Cédula de Ciudadanía,Cédula de Extranjería,Pasaporte,Permiso Especial',
            'numero_de_identificacion' => [
                'nullable',
                'alpha_dash',
                'max:20',
                Rule::unique('empleados')->ignore($this->route('id'))
            ],
            'fecha_de_ingreso' => 'nullable|date|before_or_equal:today|after_or_equal:' . now()->subMonth()->toDateString(),
            'area' => 'nullable|in:Administración,Financiera,Compras,Infraestructura,Operación,Talento Humano,Servicios Varios'
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
