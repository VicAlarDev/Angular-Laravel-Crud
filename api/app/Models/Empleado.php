<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $fillable = [
        'primer_apellido',
        'segundo_apellido',
        'primer_nombre',
        'otros_nombres',
        'pais_del_empleo',
        'tipo_de_identificacion',
        'numero_de_identificacion',
        'correo_electronico',
        'fecha_de_ingreso',
        'area',
        'estado',
        'fecha_hora_de_registro'
    ];

    protected $dates = ['fecha_de_ingreso', 'fecha_hora_de_registro'];
}
