<?php

declare(strict_types=1);

namespace Magma\Session\Storage;

class NativeSessionStorage extends AbstractSessionStorage
{
  /**
   * Class constructor
   * 
   * @param array $options
   * @return void
   */ 
  public function __construct(array $options = [])
  {
    parent::__construct($options);
  }

  /** @inheritDoc */
  public function setSession(string $key, mixed $value): void
  {
    $_SESSION[$key] = $value;
  }
  
  /** @inheritDoc */
  public function setArraySession(string $key, mixed $value): void
  {
    $_SESSION[$key][] = $value;
  }

  /** @inheritDoc */
  public function getSession(string $key, mixed $default = null): mixed
  {
    if ($this->hasSession($key))
      return $_SESSION[$key];
    return $default;
  }

  /** @inheritDoc */
  public function deleteSession(string $key): void
  {
    if ($this->hasSession($key))
      unset($_SESSION[$key]);
  }  

  /** @inheritDoc */
  public function invalidate(): void
  {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
      $params = session_get_cookie_params();
      setcookie($this->getSessionName(), '', 
        time() - $params['lifetime'], 
        $params['path'], 
        $params['domain'], 
        $params['secure'], 
        $params['httponly']
      );
    }
    session_unset();
    session_destroy();
  }

  /** @inheritDoc */
  public function flush(string $key, mixed $default = null): mixed
  {
    if ($this->hasSession($key)) {
      $value = $_SESSION[$key];
      $this->deleteSession($key);
      return $value;
    }
    return $default;
  }

  /** @inheritDoc */
  public function hasSession(string $key): bool
  {
    return isset($_SESSION[$key]);
  }

}
