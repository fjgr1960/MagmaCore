<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\EntityManager;

interface CrudInterface
{
  /**
   * getSchema function
   *
   * @return string
   */
  public function getSchema(): string;

  /**
   * getSchemaID function
   *
   * @return string
   */
  public function getSchemaID(): string;

  /**
   * lastID function
   *
   * @return integer
   */
  public function lastID(): int;

  /**
   * create function
   *
   * @param array $fields
   * @return boolean
   * @throws Throwable
   */
  public function create(array $fields): bool;

  /**
   * read function
   *
   * @param array $selectors
   * @param array $conditions
   * @param array $parameters
   * @param array $optional
   * @return array
   * @throws Throwable
   */
  public function read(array $selectors, array $conditions, array $parameters, array $optional): array;

  /**
   * update function
   *
   * @param array $fields
   * @param string $primaryKey
   * @return boolean
   * @throws Throwable
   */
  public function update(array $fields, string $primaryKey): bool;

  /**
   * delete function
   *
   * @param array $conditions
   * @return boolean
   * @throws Throwable
   */
  public function delete(array $conditions): bool;

  /**
   * search function
   *
   * @param array $selectors
   * @param array $conditions
   * @return array
   * @throws Throwable
   */
  public function search(array $selectors, array $conditions): array;

  /**
   * rawQuery function
   *
   * @param string $rawQuery
   * @param array $conditions
   * @return mixed
   */
  public function rawQuery(string $rawQuery, array $conditions): mixed;

}
