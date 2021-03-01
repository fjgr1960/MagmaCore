<?php

declare(strict_types=1);

namespace Magma\Router;

use Exception;

class Router implements RouterInterface
{
  /** properties */
  protected array $routes = [];
  protected array $params = [];
  protected string $controllerSuffix = 'controller';

  /** @inheritDoc */
  public function add(string $route, array $params = []): void
  {
    $this->routes[$route] = $params;
  }

  /** @inheritDoc */
  public function dispatch(string $url): void
  {
    if ($this->match($url)) {
      $controllerString = $this->params['controller'];
      $controllerString = $this->tranformUpperCamelCase($controllerString);
      $controllerString = $this->getNamespace($controllerString);

      if (class_exists($controllerString)) {
        $controllerObject = new $controllerString();
        $action = $this->params['action'];
        $action = $this->transformCamelCase($action);

        if (is_callable($controllerObject, $action))
          $controllerObject->$action();
        else throw new Exception();
      }
      else throw new Exception();
    }
    else throw new Exception();
  }

  /**
   * tranformUpperCamelCase function
   *
   * @param string $str
   * @return string
   */
  private function tranformUpperCamelCase(string $str): string
  {
    return str_replace(' ', '', ucwords(str_replace('-', ' ', $str)));
  }

  /**
   * transformCamelCase function
   *
   * @param string $str
   * @return string
   */
  private function transformCamelCase(string $str): string
  {
    return lcfirst($this->tranformUpperCamelCase($str));
  }

  /**
   * match function
   * Find a match for the given url in the routing table
   *
   * @param string $url
   * @return boolean
   */
  private function match(string $url): bool
  {
    foreach ($this->routes as $route => $params)
      if (preg_match($route, $url, $matches)) {
        foreach ($matches as $key => $param)
          if (is_string($key))
            $params[$key] = $param;
        $this->params = $params;
        return true;
      }
    return false;
  }

  /**
   * getNamespace function
   *
   * @param string $str
   * @return string
   */
  private function getNamespace(string $str): string
  {
    $namespace = 'App\Controller\\';
    if (array_key_exists('namespace', $this->params))
      $namespace .= $this->params['namespace'] . '\\';
    return $namespace;
  }

}
