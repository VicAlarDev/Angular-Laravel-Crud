<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class ApiResponseClass
{
  public static function rollback($e, $message = "¡Algo salió mal! Proceso no completado")
  {
    DB::rollBack();
    self::logError($e, $message);
    throw new HttpResponseException(response()->json(["message" => $message], 500));
  }

  public static function throw($e, $message = "¡Algo salió mal! Proceso no completado")
  {
    self::logError($e, $message);
    throw new HttpResponseException(response()->json(["message" => $message], 500));
  }

  public static function sendResponse($result, $message, $code = 200)
  {
    $response = [
      'success' => true,
      'data' => $result
    ];
    if (!empty($message)) {
      $response['message'] = $message;
    }
    Log::info("Respuesta enviada", ['response' => $response]);
    return response()->json($response, $code);
  }

  private static function logError($e, $message)
  {
    Log::error($message, [
      'exception' => [
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
      ]
    ]);
  }
}
