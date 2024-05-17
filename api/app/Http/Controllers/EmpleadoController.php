<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmpleadoRequest;
use App\Http\Requests\UpdateEmpleadoRequest;
use App\Services\EmpleadoService;

class EmpleadoController extends Controller
{
    protected $empleadoService;

    public function __construct(EmpleadoService $empleadoService)
    {
        $this->empleadoService = $empleadoService;
    }

    public function index()
    {
        return $this->empleadoService->getEmpleados();
    }

    public function store(StoreEmpleadoRequest $request)
    {
        return $this->empleadoService->createEmpleado($request);
    }

    public function show($id)
    {
        return $this->empleadoService->getEmpleado($id);
    }

    public function update(UpdateEmpleadoRequest $request, $id)
    {
        return $this->empleadoService->updateEmpleado($request, $id);
    }

    public function destroy($id)
    {
        return $this->empleadoService->deleteEmpleado($id);
    }
}
