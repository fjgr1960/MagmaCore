<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\DataRepository;

use Magma\LiquidOrm\DataRepository\Exception\DataRepositoryException;

class DataRepositoryFactory
{
  /**
   * Class constructor
   * 
   * @var string $crudID
   * @var string $tableSchema
   * @var string $tableSchemaID
   * @return void
   */
  public function __construct(
    protected string $crudID,
    protected string $tableSchema,
    protected string $tableSchemaID
  )
  {}

  public function create(string $dataRepositoryString): DataRepository
  {
    $dataRepositoryObject = new $dataRepositoryString();
    if (!$dataRepositoryObject instanceof DataRepository) {
      throw new DataRepositoryException("
        $dataRepositoryString is not a valid DataRepository object!
      ");
    }
    return $dataRepositoryObject;
  }

}
