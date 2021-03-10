<?php

declare(strict_types=1);

namespace Magma\Base;

use Magma\LiquidOrm\DataRepository\DataRepository;
use Magma\Base\Exception\BaseInvalidArgumentException;
use Magma\LiquidOrm\DataRepository\DataRepositoryFactory;

class BaseModel
{
  /** properties */
  private DataRepository $repository;
  
  /**
   * Class constructor
   * 
   * @param string $tableSchema
   * @param string $tableSchemaID
   * @return void
   */
  public function __construct(private string $tableSchema, private string $tableSchemaID)
  {
    if (empty($this->tableSchema) || empty($this->tableSchemaID)) {
      throw new BaseInvalidArgumentException("Required arguments!");
    }
    $factory = new DataRepositoryFactory('', $this->tableSchema, $this->tableSchemaID);
    $this->repository = $factory->create(DataRepository::class);
  }

  /**
   * getRepository function
   *
   * @return DataRepository
   */
  public function getRepository(): DataRepository
  {
    return $this->repository;
  }

}
