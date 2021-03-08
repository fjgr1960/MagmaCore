<?php

declare(strict_types=1);

namespace Magma\Session\Storage;

abstract class AbstractSessionStorage implements SessionStorageInterface
{
  /**
   * Class constructor
   * 
   * @param array $options
   * @return void
   */
  public function __construct(protected array $options = [])
  {
    $this->iniSet();
    if ($this->isSessionStarted()) {
      session_unset();
      session_destroy();
    }
    $this->start();
  }

  /** @inheritDoc */
  public function setSessionName(string $sessionName): void
  {
    session_name($sessionName);
  }

  /** @inheritDoc */
  public function getSessionName(): string
  {
    return session_name();
  }

  /** @inheritDoc */
  public function setSessionID(string $sessionID): void
  {
    session_id($sessionID);
  }

  /** @inheritDoc */
  public function getSessionID(): string
  {
    return session_id();
  }

  /**
   * iniSet function
   *
   * @return void
   */
  public function iniSet(): void
  {
    ini_set('session.gc_maxlifetime', $this->options['gc_maxlifetime']);
    ini_set('session.gc_divisor', $this->options['gc_divisor']);
    ini_set('session.gc_probability', $this->options['gc_probability']);
    ini_set('session.cookie_lifetime', $this->options['cookie_lifetime']);
    ini_set('session.use_cookies', $this->options['use_cookies']);
  }

  /**
   * isSessionStarted function
   *
   * @return boolean
   */
  public function isSessionStarted(): bool
  {
    return (php_sapi_name() !== 'cli') 
      ? $this->getSessionID() !== ''
      : false;
  }

  /**
   * startSession function
   *
   * @return void
   */
  public function startSession(): void
  {
    if (session_status() === PHP_SESSION_NONE)
      session_start();
  }

  /**
   * start function
   *
   * @return void
   */
  public function start(): void
  {
    $this->setSessionName($this->options['session_name']);
    session_set_cookie_params(
      $this->options['lifetime'], 
      $this->options['path'], 
      $this->options['domain'] ?? isset($_SERVER['SERVER_NAME']), 
      $this->options['secure'] ?? isset($_SERVER['HTTPS']), 
      $this->options['httponly']
    );
    $this->startSession();
  }

}
