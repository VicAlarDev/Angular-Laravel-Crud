<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmpleadoResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'primer_apellido' => $this->primer_apellido,
            'segundo_apellido' => $this->segundo_apellido,
            'primer_nombre' => $this->primer_nombre,
            'otros_nombres' => $this->otros_nombres,
            'pais_del_empleo' => $this->pais_del_empleo,
            'tipo_de_identificacion' => $this->tipo_de_identificacion,
            'numero_de_identificacion' => $this->numero_de_identificacion,
            'correo_electronico' => $this->correo_electronico,
            'fecha_de_ingreso' => $this->fecha_de_ingreso ? $this->fecha_de_ingreso->toIso8601String() : null,
            'area' => $this->area,
            'estado' => $this->estado,
            'fecha_hora_de_registro' => $this->fecha_hora_de_registro ? $this->fecha_hora_de_registro->toIso8601String() : null
        ];
    }
}
