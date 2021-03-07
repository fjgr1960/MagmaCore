<?php

declare(strict_types=1);

namespace Magma\LiquidOrm;

use Magma\LiquidOrm\EntityManager\Crud;
use Magma\LiquidOrm\QueryBuilder\QueryBuilder;
use Magma\DatabaseConnection\DatabaseConnection;
use Magma\LiquidOrm\EntityManager\EntityManager;
use Magma\LiquidOrm\DataMapper\DataMapperFactory;
use Magma\LiquidOrm\QueryBuilder\QueryBuilderFactory;
use Magma\LiquidOrm\EntityManager\EntityManagerFactory;
use Magma\LiquidOrm\DataMapper\DataMapperEnvironmentConfiguration;

class LiquidOrmManager
{
  /**
   * Class constructor
   * 
   * @var DataMapperEnvironmentConfiguration $environmentConfiguration
   * @var string $tableSchema
   * @var string $tableSchemaID
   * @return void
   */
  public function __construct(
    protected DataMapperEnvironmentConfiguration $environmentConfiguration,
    protected string $tableSchema,
    protected string $tableSchemaID,
    protected ?array $options = []
  )
  {}

  /**
   * intialize function
   *
   * @return EntityManager
   */
  public function intialize(): EntityManager
  {
    $dataMapperFactory = new DataMapperFactory();
    $dataMapper = $dataMapperFactory
      ->create(DatabaseConnection::class, DataMapperEnvironmentConfiguration::class);
    if ($dataMapper) {

      $queryBuilderFactory = new QueryBuilderFactory();
      $queryBuilder = $queryBuilderFactory
        ->create(QueryBuilder::class);
      if ($queryBuilder) {

        $entityManagerFactory = new EntityManagerFactory($dataMapper, $queryBuilder);
        return $entityManagerFactory
          ->create(Crud::class, $this->tableSchema, $this->tableSchemaID, $this->options);
      }
    }
  }

}
