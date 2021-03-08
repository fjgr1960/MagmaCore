<?php

declare(strict_types=1);

namespace Magma\GlobalsManager;

interface GlobalsManagerInterface
{
  /**
   * Set the $GLOBALS variable
   *
   * @param string $key
   * @param mixed $value
   * @return void
   */
  public static function set(string $key, mixed $value): void;

  /**
   * Get the value from the $GLOBALS variable for a given key
   *
   * @param string $key
   * @return mixed
   * @throws GlobalsManagerException
   * @throws GlobalsManagerInvalidArgumentException
   */
  public static function get(string $key): mixed;

}
