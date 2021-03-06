<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\QueryBuilder;

use Magma\LiquidOrm\QueryBuilder\Exception\QueryBuilderException;

class QueryBuilderFactory
{
  /**
   * Class constructor
   * 
   * @return void
   */
  public function __construct()
  {}

  /**
   * create function
   *
   * @param string $queryBuilderString
   * @return QueryBuilder
   * @throws QueryBuilderException
   */
  public function create(string $queryBuilderString): QueryBuilder
  {
    $queryBuilderObject = new $queryBuilderString();
    if (!$queryBuilderObject instanceof QueryBuilder)
      throw new QueryBuilderException("
        $queryBuilderString is not a valid QueryBuilder object!
      ");
    return new QueryBuilder();
  }

}
