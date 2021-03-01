<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\DataMapper;

use Magma\LiquidOrm\DataMapper\Exception\DataMapperInvalidArgumentException;

class DataMapperEnvironmentConfiguration
{
  /**
   * Class constructor
   * 
   * @param array $credentials
   * @return void
   */
  public function __construct(
    private array $credentials
  )
  {}

  /**
   * getDatabaseCredentials function
   *
   * @param string $driver
   * @return array
   */
  public function getDatabaseCredentials(string $driver): array
  {
    $connectionString = [];
    foreach ($this->credentials as $credential)
      if (array_key_exists($driver, $credential))
        $connectionString = $credential[$driver];
    return $connectionString;
  }

  /**
   * isValid function
   *
   * @param string $driver
   * @return void
   * @throws DataMapperInvalidArgumentException
   */
  private function isValid(string $driver): void
  {
    if (empty($driver) || !in_array($driver, array_keys($this->credentials[$driver])))
      throw new DataMapperInvalidArgumentException('Driver is either missing or unsupported!');
  }

}
