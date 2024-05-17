<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('primer_apellido', 20);
            $table->string('segundo_apellido', 20);
            $table->string('primer_nombre', 20);
            $table->string('otros_nombres', 50)->nullable();
            $table->enum('pais_del_empleo', ['Colombia', 'Estados Unidos']);
            $table->enum('tipo_de_identificacion', [
                'Cédula de Ciudadanía',
                'Cédula de Extranjería',
                'Pasaporte',
                'Permiso Especial'
            ]);
            $table->string('numero_de_identificacion', 20);
            $table->string('correo_electronico', 300)->unique();
            $table->date('fecha_de_ingreso');
            $table->enum('area', [
                'Administración',
                'Financiera',
                'Compras',
                'Infraestructura',
                'Operación',
                'Talento Humano',
                'Servicios Varios'
            ]);
            $table->enum('estado', ['Activo'])->default('Activo');
            $table->timestamp('fecha_hora_de_registro')->useCurrent();
            $table->timestamps();

            $table->unique(['tipo_de_identificacion', 'numero_de_identificacion']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
