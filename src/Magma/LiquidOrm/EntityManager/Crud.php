<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\EntityManager;

use Magma\LiquidOrm\DataMapper\DataMapper;
use Magma\LiquidOrm\QueryBuilder\QueryBuilder;
use Throwable;

class Crud implements CrudInterface
{
  /**
   * Class constructor
   * 
   * @param DataMapper $dataMapper
   * @param QueryBuilder $queryBuilder
   * @param string $tableSchema
   * @param string $tableSchemaID
   * @return void
   */
  public function __construct(
    protected DataMapper $dataMapper,
    protected QueryBuilder $queryBuilder,
    protected string $tableSchema,
    protected string $tableSchemaID
  )
  {}

  /** @inheritDoc */
  public function getSchema(): string
  {
    return $this->tableSchema;
  }

  /** @inheritDoc */
  public function getSchemaID(): string
  {
    return $this->tableSchemaID;
  }

  /** @inheritDoc */
  public function lastID(): int
  {
    return $this->dataMapper->getLastId();
  }

  /** @inheritDoc */
  public function create(array $fields = []): bool
  {
    try {
      $args = [
        'table' => $this->getSchema(),
        'type' => 'insert',
        'fields' => $fields,
      ];
      $query = $this->queryBuilder->buildQuery($args)->insertQuery();
      $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($fields));
      if ($this->dataMapper->numRows()) {
        return true;
      }
    }
    catch (Throwable $th) {
      throw $th;
    }
  }

  /** @inheritDoc */
  public function read(array $selectors = [], array $conditions = [], array $parameters = [], array $optional = []): array
  {
    try {
      $args = [
        'table' => $this->getSchema(),
        'type' => 'select',
        'selectors' => $selectors,
        'conditions' => $conditions,
        'params' => $parameters,
        'extras' => $optional,
      ];
      $query = $this->queryBuilder->buildQuery($args)->selectQuery();
      $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($conditions, $parameters));
      if ($this->dataMapper->numRows()) {
        return $this->dataMapper->results();
      }
    }
    catch (Throwable $th) {
      throw $th;
    }
  }

  /** @inheritDoc */
  public function update(array $fields = [], string $primaryKey): bool
  {
    try {
      $args = [
        'table' => $this->getSchema(),
        'type' => 'update',
        'fields' => $fields,
        'primaryKey' => $primaryKey,
      ];
      $query = $this->queryBuilder->buildQuery($args)->updateQuery();
      $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($fields));
      if ($this->dataMapper->numRows()) {
        return true;
      }
    }
    catch (Throwable $th) {
      throw $th;
    }
  }

  /** @inheritDoc */
  public function delete(array $conditions = []): bool
  {
    try {
      $args = [
        'table' => $this->getSchema(),
        'type' => 'delete',
        'conditions' => $conditions,
      ];
      $query = $this->queryBuilder->buildQuery($args)->deleteQuery();
      $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($conditions));
      if ($this->dataMapper->numRows()) {
        return true;
      }
    }
    catch (Throwable $th) {
      throw $th;
    }
  }

  /** @inheritDoc */
  public function search(array $selectors, array $conditions): array
  {
    try {
      $args = [
        'table' => $this->getSchema(),
        'type' => 'search',
        'selectors' => $selectors,
        'conditions' => $conditions,
      ];
      $query = $this->queryBuilder->buildQuery($args)->searchQuery();
      $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($conditions));
      if ($this->dataMapper->numRows()) {
        return $this->dataMapper->results();
      }
    }
    catch (Throwable $th) {
      throw $th;
    }
  }

  /** @inheritDoc */
  public function rawQuery(string $rawQuery, array $conditions): mixed
  {}

}
