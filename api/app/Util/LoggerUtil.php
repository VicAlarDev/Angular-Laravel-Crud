<?php

namespace App\Util;

use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;

class LoggerUtil
{
  public static function createLogger($name = 'app')
  {
    $logger = new Logger($name);

    // Definir el formato del Logger
    $dateFormat = "Y-m-d H:i:s";
    $output = "[%datetime%] [%level_name%] %channel%: %message% %context%\n";
    $formatter = new LineFormatter($output, $dateFormat);

    // Manejador de archivos rotativos
    $stream = new RotatingFileHandler(__DIR__ . '/../../storage/logs/app.log', 7, Logger::DEBUG);
    $stream->setFormatter($formatter);

    $logger->pushHandler($stream);

    return $logger;
  }
}
