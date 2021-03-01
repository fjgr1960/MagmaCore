<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\DataMapper;

use Magma\DatabaseConnection\DatabaseConnection;
use Magma\LiquidOrm\DataMapper\Exception\DataMapperException;

class DataMapperFactory
{
  /**
   * Class constructor
   * 
   * @return void
   */
  public function __construct()
  {}

  /**
   * create function
   *
   * @param string $databaseConnectionString
   * @param string $dataMapperEnvironmentConfiguration
   * @return DataMapper
   * @throws DataMapperException
   */
  public function create(
    string $databaseConnectionString,
    string $dataMapperEnvironmentConfiguration
  ): DataMapper
  {
    $credentials = (new $dataMapperEnvironmentConfiguration([]))
      ->getDatabaseCredentials('mysql');

    $databaseConnectionObject = new $databaseConnectionString($credentials);
    if (!$databaseConnectionObject instanceof DatabaseConnection)
      throw new DataMapperException("
        $databaseConnectionString is not a valid database connection object
      ");
    
    return new DataMapper($databaseConnectionObject);
  }

}
