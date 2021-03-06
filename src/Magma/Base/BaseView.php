<?php

declare(strict_types=1);

namespace Magma\Base;

use Twig\Environment;
use Magma\Twig\TwigExtension;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;

class BaseView
{
  /**
   * getTemplate function
   *
   * @param string $template
   * @param array $context
   * @return string
   */
  public function getTemplate(string $template, array $context = []): string
  {
    static $twig;
    if ($twig === null) {
      $loader = new FilesystemLoader('templates', TEMPLATES_PATH);
      $twig = new Environment($loader, []);
      $twig->addExtension(new DebugExtension());
      $twig->addExtension(new TwigExtension());
    }
    return $twig->render($template, $context);
  }

}
