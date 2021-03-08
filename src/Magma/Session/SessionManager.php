<?php

declare(strict_types=1);

namespace Magma\Session;

use Magma\Session\Storage\NativeSessionStorage;

class SessionManager
{
  /**
   * initialize function
   *
   * @return Session
   */
  public function initialize(): Session
  {
    $factory = new SessionFactory();
    return $factory->create('', NativeSessionStorage::class);
  }

}
