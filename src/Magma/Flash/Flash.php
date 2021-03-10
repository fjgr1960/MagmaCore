<?php

declare(strict_types=1);

namespace Magma\Flash;

use Magma\GlobalsManager\GlobalsManager;

class Flash implements FlashInterface
{
  /** properties */
  protected const FLASH_KEY = 'flash_message';

  /** @inheritDoc */
  public static function add(string $message, string $type = FlashTypes::SUCCESS): void
  {
    $session = GlobalsManager::get('global_session');
    if (!$session->has(self::FLASH_KEY))
      $session->set(self::FLASH_KEY, []);

    $session->setArray(self::FLASH_KEY, [
      'message' => $message, 
      'type' => $type
    ]);
  }

  /** @inheritDoc */
  public static function get(): void
  {
    $session = GlobalsManager::get('global_session');
    $session->flush(self::FLASH_KEY);
  }

}
