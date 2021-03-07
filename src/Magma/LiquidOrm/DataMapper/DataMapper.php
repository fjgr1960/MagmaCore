<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\DataMapper;

use PDO;
use Throwable;
use PDOStatement;
use Magma\DatabaseConnection\DatabaseConnection;
use Magma\LiquidOrm\DataMapper\Exception\DataMapperException;

class DataMapper implements DataMapperInterface
{
  /** properties */
  private PDOStatement $stmt;

  /**
   * Class constructor
   * 
   * @param DatabaseConnection $dbh
   * @return void
   */
  public function __construct(
    private DatabaseConnection $dbh
  )
  {}

  /**
   * isEmpty function
   *
   * @param mixed $value
   * @param string $errorMessage
   * @return void
   * @throws DataMapperException
   */
  private function isEmpty(mixed $value, string $errorMessage = null): void
  {
    if (empty($value)) {
      throw new DataMapperException($errorMessage);
    }
  }

  /**
   * isArray function
   *
   * @param mixed $value
   * @return void
   * @throws DataMapperException
   */
  private function isArray(mixed $value): void
  {
    if (!is_array($value)) {
      throw new DataMapperException('This argument needs to be an array!');
    }
  }

  /** @inheritDoc */
  public function prepare(string $sqlQuery): self
  {
    $this->stmt = $this->dbh->open()->prepare($sqlQuery);
    return $this;
  }

  /** @inheritDoc */
  public function bind(mixed $value): int
  {
    try {
      switch ($value) {
        case is_bool($value):
        case intval($value):
          $dataType = PDO::PARAM_INT;
          break;
        
        case is_null($value):
          $dataType = PDO::PARAM_NULL;
          break;
        
        default:
          $dataType = PDO::PARAM_STR;
      }
      return $dataType;
    }
    catch (DataMapperException $e) {
      throw new $e;
    }
  }

  /**
   * bindValues function
   *
   * @param mixed $values
   * @return PDOStatement
   * @throws DataMapperException
   */
  protected function bindValues(mixed $values): PDOStatement
  {
    $this->isArray($values);
    foreach ($values as $key => $value)
      $this->stmt->bindValue(":$key", $value, $this->bind($value));
    return $this->stmt;
  }

  /**
   * bindSearchValues function
   *
   * @param mixed $values
   * @return PDOStatement
   * @throws DataMapperException
   */
  protected function bindSearchValues(mixed $values): PDOStatement
  {
    $this->isArray($values);
    foreach ($values as $key => $value)
      $this->stmt->bindValue(":$key", "%$value%", $this->bind($value));
    return $this->stmt;
  }

  /** @inheritDoc */
  public function bindParameters(mixed $values, bool $isSearch = false): self
  {
    if ($this->isArray($values)) {
      $bindType = ($isSearch === false) 
        ? $this->bindValues($values) 
        : $this->bindSearchValues($values);
      if ($bindType) return $this;
    }
    return false;
  }

  /** @inheritDoc */
  public function numRows(): int
  {
    if ($this->stmt)
      return $this->stmt->rowCount();
  }

  /** @inheritDoc */
  public function execute(): bool
  {
    if ($this->stmt)
      return $this->stmt->execute();
  }

  /** @inheritDoc */
  public function result(): object
  {
    if ($this->stmt)
      return $this->stmt->fetch(PDO::FETCH_OBJ);
  }

  /** @inheritDoc */
  public function results(): array
  {
    if ($this->stmt)
      return $this->stmt->fetchAll();
  }

  /** @inheritDoc */
  public function getLastId(): int
  {
    try {
      if ($this->dbh->open())
        $lastID = $this->dbh->open()->lastInsertId();
        if (!empty($lastID)) return intval($lastID);
    }
    catch (Throwable $th) {
      throw $th;
    }
  }

  /**
   * buildQueryParameters function
   *
   * @param array $conditions
   * @param array $parameters
   * @return array
   */
  public function buildQueryParameters(array $conditions = [], array $parameters = []): array
  {
    return (!empty($conditions) || !empty($parameters))
      ? array_merge($conditions, $parameters)
      : $parameters;
  }

  /**
   * persist function
   *
   * @param string $sqlQuery
   * @param array $parameters
   * @return boolean
   * @throws Throwable
   */
  public function persist(string $sqlQuery, array $parameters): bool
  {
    try {
      return $this->prepare($sqlQuery)->bindParameters($parameters)->execute();
    }
    catch (Throwable $th) {
      throw $th;
    }
  }

}
