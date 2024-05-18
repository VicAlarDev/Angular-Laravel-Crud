<?php

namespace App\Services;

use App\Repositories\EmpleadoRepository;
use App\Models\Empleado;
use App\Http\Requests\StoreEmpleadoRequest;
use App\Http\Requests\UpdateEmpleadoRequest;
use App\Classes\ApiResponseClass;
use App\Util\LoggerUtil;
use Exception;

class EmpleadoService
{
  protected $empleadoRepository;
  protected $logger;

  public function __construct(EmpleadoRepository $empleadoRepository)
  {
    $this->empleadoRepository = $empleadoRepository;
    $this->logger = LoggerUtil::createLogger('EmpleadoService');
  }

  public function createEmpleado(StoreEmpleadoRequest $request)
  {
    try {
      $data = $request->validated();
      $data['correo_electronico'] = $this->generateEmail($data['primer_nombre'], $data['primer_apellido'], $data['pais_del_empleo']);
      $this->logger->info('Empleado creado con éxito', ['data' => $data]);
      return ApiResponseClass::sendResponse($this->empleadoRepository->store($data), 'Empleado creado con éxito');
    } catch (Exception $e) {
      $this->logger->error("Ha ocurrido un error al intentar crear un empleado", ['exception' => $e, 'data' => $data]);
      return ApiResponseClass::rollback($e, "Ha ocurrido un error al intentar crear un empleado");
    }
  }

  public function updateEmpleado(UpdateEmpleadoRequest $request, $id)
  {
    try {
      $data = $request->validated();
      $empleado = $this->empleadoRepository->getById($id);

      if (!$empleado) {
        $this->logger->warning('Empleado no encontrado', ['id' => $id]);
        return ApiResponseClass::sendResponse(['errors' => 'Empleado no encontrado'], 'Empleado no encontrado', 404);
      }

      // Update email only if there are changes that affect it
      if (isset($data['primer_nombre']) || isset($data['primer_apellido']) || isset($data['pais_del_empleo'])) {
        $data['correo_electronico'] = $this->generateEmail(
          $data['primer_nombre'] ?? $empleado->primer_nombre,
          $data['primer_apellido'] ?? $empleado->primer_apellido,
          $data['pais_del_empleo'] ?? $empleado->pais_del_empleo,
          $data['id'] ?? $empleado->id
        );
      }

      $this->empleadoRepository->update($data, $id);
      $this->logger->info('Empleado actualizado con éxito', ['id' => $id, 'data' => $data]);
      return ApiResponseClass::sendResponse($data, 'Empleado actualizado con éxito');
    } catch (Exception $e) {
      $this->logger->error("Ha ocurrido un error al intentar actualizar el empleado", ['id' => $id, 'exception' => $e, 'data' => $data]);
      return ApiResponseClass::rollback($e, "Ha ocurrido un error al intentar actualizar el empleado");
    }
  }

  public function deleteEmpleado($id)
  {
    try {
      $result = $this->empleadoRepository->delete($id);

      if ($result) {
        $this->logger->info("Empleado eliminado con éxito", ['id' => $id]);
        return ApiResponseClass::sendResponse([], 'Empleado eliminado con éxito');
      } else {
        $this->logger->warning("Error al eliminar el empleado, id no registrado", ['id' => $id]);
        return ApiResponseClass::sendResponse(['errors' => 'Empleado no encontrado'], 'Empleado no encontrado', 404);
      }
    } catch (Exception $e) {
      $this->logger->error("Ha ocurrido un error al intentar eliminar un empleado", ['id' => $id, 'exception' => $e]);
      return ApiResponseClass::rollback($e, "Error al eliminar el empleado");
    }
  }

  public function getEmpleado($id)
  {
    try {
      $empleado = $this->empleadoRepository->getById($id);

      if (!$empleado) {
        $this->logger->warning("Empleado no encontrado", ['id' => $id]);
        return ApiResponseClass::sendResponse(['errors' => 'Empleado no encontrado'], 'Empleado no encontrado', 404);
      } else {
        $this->logger->info("Empleado obtenido con éxito", ['id' => $id]);
        return ApiResponseClass::sendResponse($empleado, 'Empleado obtenido con éxito');
      }
    } catch (Exception $e) {
      $this->logger->error("Ha ocurrido un error al intentar obtener los datos del empleado", ['id' => $id, 'exception' => $e]);
      throw $e;
    }
  }

  public function getEmpleados()
  {
    try {
      $empleados = $this->empleadoRepository->index();
      $this->logger->info("Todos los empleados obtenidos con éxito", ['count' => count($empleados)]);
      return ApiResponseClass::sendResponse($empleados, 'Todos los empleados obtenidos con éxito');
    } catch (Exception $e) {
      $this->logger->error("Ha ocurrido un error al intentar obtener todos los empleados", ['exception' => $e]);
      return ApiResponseClass::rollback($e, "Error al obtener todos los empleados");
    }
  }

  public function getEmpleadosPaginated($num)
  {
    try {
      $empleados = $this->empleadoRepository->paginated($num);
      $this->logger->info("Todos los empleados paginados obtenidos con éxito", ['count' => count($empleados)]);
      return ApiResponseClass::sendResponse($empleados, 'Todos los empleados paginados obtenidos con éxito');
    } catch (Exception $e) {
      $this->logger->error("Ha ocurrido un error al intentar obtener todos los empleados paginados", ['exception' => $e]);
      return ApiResponseClass::rollback($e, "Error al obtener todos los empleados paginados");
    }
  }

  private function generateEmail($primer_nombre, $primer_apellido, $pais, $empleadoId = null)
  {
    $dominio = $pais === 'Colombia' ? 'global.com.co' : 'global.com.us';
    $email_base = strtolower($primer_nombre . '.' . $primer_apellido);
    $email = $email_base . '@' . $dominio;
    $counter = 1;

    while (
      Empleado::where('correo_electronico', $email)
        ->when($empleadoId, function ($query, $empleadoId) {
          return $query->where('id', '!=', $empleadoId);
        })
        ->exists()
    ) {
      $email = $email_base . '.' . $counter . '@' . $dominio;
      $counter++;
    }

    return $email;
  }

}