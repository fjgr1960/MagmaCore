<?php

declare(strict_types=1);

namespace Magma\DatabaseConnection\Exception;

use PDOException;

class DatabaseConnectionException extends PDOException
{
  /**
   * Class constructor
   *
   * @param protected $message
   * @param protected $code
   */
  public function __construct(
    protected $message = null,
    protected $code = null
  )
  {}
  
}
