<?php

declare(strict_types=1);

namespace Magma\Session\Storage;

interface SessionStorageInterface
{
  /**
   * setSession function
   *
   * @param string $key
   * @param mixed $value
   * @return void
   */
  public function setSession(string $key, mixed $value): void;
  
  /**
   * setArraySession function
   *
   * @param string $key
   * @param mixed $value
   * @return void
   */
  public function setArraySession(string $key, mixed $value): void;
  
  /**
   * getSession function
   *
   * @param string $key
   * @param mixed $default
   * @return mixed
   */ 
  public function getSession(string $key, mixed $default): mixed;

  /**
   * deleteSession function
   *
   * @param string $key
   * @return void
   */ 
  public function deleteSession(string $key): void;

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
   * @param mixed $default
   * @return mixed
   */
  public function flush(string $key, mixed $default): mixed;

  /**
   * hasSession function
   *
   * @param string $key
   * @return boolean
   */  
  public function hasSession(string $key): bool;
  
  /**
   * setSessionName function
   *
   * @param string $sessionName
   * @return void
   */ 
  public function setSessionName(string $sessionName): void;

  /**
   * getSessionName function
   *
   * @return string
   */ 
  public function getSessionName(): string;

  /**
   * setSessionID function
   *
   * @param string $sessionID
   * @return void
   */ 
  public function setSessionID(string $sessionID): void;

  /**
   * getSessionID function
   *
   * @return string
   */ 
  public function getSessionID(): string;

}
