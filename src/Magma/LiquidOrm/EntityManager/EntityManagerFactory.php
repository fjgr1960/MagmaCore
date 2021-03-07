<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\EntityManager;

use Magma\LiquidOrm\DataMapper\DataMapper;
use Magma\LiquidOrm\QueryBuilder\QueryBuilder;
use Magma\LiquidOrm\EntityManager\Exception\CrudException;

class EntityManagerFactory
{
  /**
   * Class constructor
   * 
   * @param DataMapper $dataMapper
   * @param QueryBuilder $queryBuilder
   * @return void
   */
  public function __construct(
    protected DataMapper $dataMapper,
    protected QueryBuilder $queryBuilder
  )
  {}

  /**
   * create function
   *
   * @param string $crudString
   * @param string $tableSchema
   * @param string $tableSchemaId
   * @param array $options
   * @return EntityManager
   * @throws CrudException
   */
  public function create(string $crudString, string $tableSchema, string $tableSchemaId, array $options = []): EntityManager
  {
    $crudObject = new $crudString();
    if (!$crudObject instanceof Crud)
      throw new CrudException("
        $crudString is not a valid Crud object!
      ");
    return new EntityManager($crudObject);
  }

}
