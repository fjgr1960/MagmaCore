<?php

declare(strict_types=1);

namespace Magma\ErrorHandling;

use ErrorException;
use Magma\Base\BaseView;

class ErrorHandling
{
  public static function errorHandler($severity, $message, $file, $line)
  {
    if (!(error_reporting() && $severity)) return;
    throw new ErrorException($message, 0, $file, $line);
  }

  public static function exceptionHandler($exception)
  {
    $code = $exception->getCode();
    if ($code !== 404) $code = 500;
    http_response_code($code);

    $error = true;
    if ($error)
      echo '<h1>Fatal Error</h1>
        <p>Uncaught exception: '. get_class($exception) .'</p>
        <p>Message: '. $exception->getMessage() .'</p>
        <p>Stack trace: '. $exception->getTraceAsString() .'</p>
        <p>Thrown in: '. $exception->getFile() .' on line '. $exception->getLine() .'</p>';
    else {
      $errorLog = LOG_DIR .'/'. date('Y-m-d H:i:s') .'.txt';
      ini_set('error_log', $errorLog);
      $message = 'Fatal Error: \n
        Uncaught exception: '. get_class($exception) .'\n
        Message: '. $exception->getMessage() .'\n
        Stack trace: '. $exception->getTraceAsString() .'\n
        Thrown in: '. $exception->getFile() .' on line '. $exception->getLine() .'\n';
      error_log($message);
      echo (new BaseView)->getTemplate("error/$code.html.twig", ['error_message' => $message]);
    }
  }

}
