<?php

declare(strict_types=1);

namespace Magma\DatabaseConnection;

use PDO;
use PDOException;
use Magma\DatabaseConnection\Exception\DatabaseConnectionException;

class DatabaseConnection implements DatabaseConnectionInterface
{
  /** properties */
  protected PDO $dbh;

  /**
   * Class constructor
   *
   * @param array $credentials
   * @return void
   */
  public function __construct(protected array $credentials)
  {}

  /** @inheritDoc */
  public function open(): PDO
  {
    try {
      $this->dbh = new PDO(
        $this->credentials['dsn'],
        $this->credentials['username'],
        $this->credentials['password'],
        [
          PDO::ATTR_EMULATE_PREPARES => false,
          PDO::ATTR_PERSISTENT => true,
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ],
      );
      return $this->dbh;
    }
    catch (PDOException $e) {
      throw new DatabaseConnectionException($e->getMessage(), (int)$e->getCode());
    }
  }

  /** @inheritDoc */
  public function close(): void
  {
    $this->dbh = null;
  }
}
