<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\EntityManager;

interface EntityManagerInterface
{
  /**
   * getCrud function
   *
   * @return object
   */
  public function getCrud(): Crud;

}
