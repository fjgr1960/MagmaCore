<?php

declare(strict_types=1);

namespace Magma\Session;

interface SessionInterface
{
  /**
   * set function
   *
   * @param string $key
   * @param mixed $value
   * @return void
   * @throws SessionException
   * @throws SessionInvalidArgumentException
   */
  public function set(string $key, mixed $value): void;

  /**
   * setArray function
   *
   * @param string $key
   * @param mixed $value
   * @return void
   * @throws SessionException
   * @throws SessionInvalidArgumentException
   */
  public function setArray(string $key, mixed $value): void;

  /**
   * get function
   *
   * @param string $key
   * @param mixed $default
   * @return mixed
   * @throws SessionException
   * @throws SessionInvalidArgumentException
   */
  public function get(string $key, mixed $default): mixed;

  /**
   * delete function
   *
   * @param string $key
   * @return void
   * @throws SessionException
   * @throws SessionInvalidArgumentException
   */
  public function delete(string $key): void;

  /**
   * invalidate function
   *
   * @return void
   */
  public function invalidate(): void;

  /**
   * flush function
   *
   * @param string $key
   * @param mixed $value
   * @return void
   * @throws SessionException
   * @throws SessionInvalidArgumentException
   */
  public function flush(string $key, mixed $value): void;

  /**
   * has function
   *
   * @param string $key
   * @return boolean
   * @throws SessionInvalidArgumentException
   */
  public function has(string $key): bool;

}
