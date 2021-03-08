<?php

declare(strict_types=1);

namespace Magma\Base;

use Magma\Base\Exception\BaseLogicException;

class BaseController
{
  /** properties */
  private object $twig;

  /**
   * Class constructor
   * 
   * @param array $routeParams
   * @return void
   */
  public function __construct(protected array $routeParams)
  {
    $this->twig = new BaseView();
  }

  public function render(string $template, array $context = []): string
  {
    if ($this->twig === null)
      throw new BaseLogicException("Twig bundle is not available!");
    return $this->twig->getTemplate($template, $context);
  }

}
