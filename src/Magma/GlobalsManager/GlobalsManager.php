<?php

declare(strict_types=1);

namespace Magma\GlobalsManager;

use Throwable;
use Magma\GlobalsManager\Exception\GlobalsManagerException;
use Magma\GlobalsManager\Exception\GlobalsManagerInvalidArgumentException;

class GlobalsManager implements GlobalsManagerInterface
{
  /** @inheritDoc */
  public static function set(string $key, mixed $value): void
  {
    $GLOBALS[$key] = $value;
  }

  /** @inheritDoc */
  public static function get(string $key): mixed
  {
    self::isValid($key);
    try {
      return $GLOBALS[$key];
    }
    catch (Throwable $th) {
      throw new GlobalsManagerException("An exception was thrown trying to get $key variable!");
    }
  }

  /**
   * isValid function
   *
   * @param string $key
   * @return void
   * @throws GlobalsManagerInvalidArgumentException
   */
  public static function isValid(string $key): void
  {
    if (empty($key))
      throw new GlobalsManagerInvalidArgumentException("Argument must not be empty!");

    if (!isset($GLOBALS[$key]))
      throw new GlobalsManagerInvalidArgumentException("$key is not a valid global variable!");
  }

}
