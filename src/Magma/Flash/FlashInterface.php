<?php

declare(strict_types=1);

namespace Magma\Flash;

interface FlashInterface
{
  /**
   * add function
   *
   * @param string $message
   * @param string $type
   * @return void
   */
  public static function add(string $message, string $type): void;

  /**
   * get function
   *
   * @return void
   */
  public static function get(): void;

}
