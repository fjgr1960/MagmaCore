<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\DataMapper;

interface DataMapperInterface
{
  /**
   * prepare function
   *
   * @param string $sqlQuery
   * @return self
   */
  public function prepare(string $sqlQuery): self;

  /**
   * bind function
   *
   * @param mixed $value
   * @return integer
   * @throws DataMapperException
   */
  public function bind(mixed $value): int;

  /**
   * bindParameters function
   *
   * @param mixed $values
   * @param boolean $isSearch
   * @return self
   * @throws DataMapperException
   */
  public function bindParameters(mixed $values, bool $isSearch): self;

  /**
   * numRows function
   *
   * @return integer
   */
  public function numRows(): int;

  /**
   * execute function
   *
   * @return boolean
   */
  public function execute(): bool;

  /**
   * result function
   *
   * @return object
   */
  public function result(): object;

  /**
   * results function
   *
   * @return array
   */
  public function results(): array;

  /**
   * getLastId function
   *
   * @return integer
   * @throws Throwable
   */
  public function getLastId(): int;

}
