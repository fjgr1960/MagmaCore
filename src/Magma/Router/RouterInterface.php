<?php

declare(strict_types=1);

namespace Magma\Router;

interface RouterInterface
{
  /**
   * add function
   * Add a route to the routing table
   *
   * @param string $route
   * @param array $params
   * @return void
   */
  public function add(string $route, array $params): void;

  /**
   * dispatch function
   * Create controller object and execute corresponding method
   *
   * @param string $url
   * @return void
   */
  public function dispatch(string $url): void;

}
