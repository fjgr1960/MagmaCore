<?php

declare(strict_types=1);

namespace Magma\DatabaseConnection;

use PDO;

interface DatabaseConnectionInterface
{
  /**
   * open function
   *
   * @return PDO
   */
  public function open(): PDO;

  /**
   * close function
   *
   * @return void
   */
  public function close(): void;

}
