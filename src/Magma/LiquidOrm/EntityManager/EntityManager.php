<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\EntityManager;

class EntityManager implements EntityManagerInterface
{
  /**
   * Class constructor
   *
   * @param Crud $crud
   * @return void
   */
  public function __construct(protected Crud $crud)
  {}

  /** @inheritDoc */
  public function getCrud(): Crud
  {
    return $this->crud;
  }

}
