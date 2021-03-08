<?php

declare(strict_types=1);

namespace Magma\Session;

use Throwable;
use Magma\Session\Exception\SessionException;
use Magma\Session\Storage\SessionStorageInterface;
use Magma\Session\Exception\SessionInvalidArgumentException;

class Session implements SessionInterface
{
  /** properties */
  protected const SESSION_PATTERN = '/^[a-zA-Z0-9_\.]{1,64}$/';

  /**
   * Class constructor
   * 
   * @param string $sessionName
   * @param SessionStorageInterface $storage
   * @return void
   * @throws SessionInvalidArgumentException
   */
  public function __construct(
    protected string $sessionName, 
    protected SessionStorageInterface $storage
  )
  {
    if (!$this->isSessionKeyValid($sessionName)) {
      throw new SessionInvalidArgumentException("$sessionName is not a valid session name!");
    }
  }

  /**
   * isSessionKeyValid function
   *
   * @param string $key
   * @return boolean
   */
  protected function isSessionKeyValid(string $key): bool
  {
    return (preg_match(self::SESSION_PATTERN, $key) === 1);
  }

  /**
   * ensureSessionKeyIsValid function
   *
   * @param string $key
   * @return void
   * @throws SessionInvalidArgumentException
   */
  protected function ensureSessionKeyIsValid(string $key): void
  {
    if ($this->isSessionKeyValid($key) === false) {
      throw new SessionInvalidArgumentException("$key is not a valid session key!");
    }
  }

  /** @inheritDoc */
  public function set(string $key, mixed $value): void
  {
    $this->ensureSessionKeyIsValid($key);
    try {
      $this->storage->setSession($key, $value);
    }
    catch (Throwable $th) {
      throw new SessionException("An exception occured trying to retrieve $key from session strorage: $th");
    }
  }

  /** @inheritDoc */
  public function setArray(string $key, mixed $value): void
  {
    $this->ensureSessionKeyIsValid($key);
    try {
      $this->storage->setArraySession($key, $value);
    }
    catch (Throwable $th) {
      throw new SessionException("An exception occured trying to retrieve $key from session strorage: $th");
    }
  }

  /** @inheritDoc */
  public function get(string $key, mixed $default = null): mixed
  {
    $this->ensureSessionKeyIsValid($key);
    try {
      return $this->storage->getSession($key, $default);
    }
    catch (Throwable $th) {
      throw new SessionException("An exception occured trying to retrieve $key from session strorage: $th");
    }
  }

  /** @inheritDoc */
  public function delete(string $key): void
  {
    $this->ensureSessionKeyIsValid($key);
    try {
      $this->storage->deleteSession($key);
    }
    catch (Throwable $th) {
      throw new SessionException("An exception occured trying to retrieve $key from session strorage: $th");
    }
  }

  /** @inheritDoc */
  public function invalidate(): void
  {
    $this->storage->invalidate();
  }

  /** @inheritDoc */
  public function flush(string $key, mixed $value): void
  {
    $this->ensureSessionKeyIsValid($key);
    try {
      $this->storage->flush($key, $value);
    }
    catch (Throwable $th) {
      throw new SessionException("An exception occured trying to retrieve $key from session strorage: $th");
    }
  }

  /** @inheritDoc */
  public function has(string $key): bool
  {
    $this->ensureSessionKeyIsValid($key);
    return $this->storage->hasSession($key);
  }

}
