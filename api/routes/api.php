<?php

use App\Http\Controllers\EmpleadoController;
use Illuminate\Support\Facades\Route;

// Empleados Routes
Route::prefix('empleados')->group(function () {
    Route::get('/', [EmpleadoController::class, 'index'])->name('empleados.index');
    Route::post('/', [EmpleadoController::class, 'store'])->name('empleados.store');
    Route::get('/{id}', [EmpleadoController::class, 'show'])->name('empleados.show');
    Route::patch('/{id}', [EmpleadoController::class, 'update'])->name('empleados.update');
    Route::delete('/{id}', [EmpleadoController::class, 'destroy'])->name('empleados.destroy');
});

