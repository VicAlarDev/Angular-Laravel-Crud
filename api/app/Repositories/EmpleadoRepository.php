<?php

namespace App\Repositories;

use App\Models\Empleado;
use App\Interfaces\EmpleadoRepositoryInterface;

class EmpleadoRepository implements EmpleadoRepositoryInterface
{
    /**
     *
     * @param mixed $id
     */
    public function delete($id)
    {
        return Empleado::find($id)->delete();
    }

    /**
     *
     * @param mixed $id
     */
    public function getById($id)
    {
        return Empleado::find($id);
    }

    /**
     */
    public function index()
    {
        return Empleado::all();
    }

    /**
     *
     * @param array $data
     */
    public function store(array $data)
    {
        return Empleado::create($data);
    }

    /**
     *
     * @param array $data
     * @param mixed $id
     */
    public function update(array $data, $id)
    {
        return Empleado::where("id", $id)->update($data);
    }

    /**
     *
     * @param mixed $num
     */
    public function paginated($num)
    {
        return Empleado::paginate($num);
    }
}
