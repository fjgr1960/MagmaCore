<?php

declare(strict_types=1);

namespace Magma\Traits;

use Magma\Session\SessionManager;
use Magma\GlobalsManager\GlobalsManager;
use Magma\Base\Exception\BaseLogicException;

trait SystemTrait
{
  public static function sessionInit(bool $useSessionGlobals = false)
  {
    $session = SessionManager::initialize();
    if (!$session)
      throw new BaseLogicException('Please enable session within your session.yaml configuration file!');
    else if ($useSessionGlobals === true)
      GlobalsManager::set('global_session', $session);
    else return $session;
  }

}
