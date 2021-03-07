<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\QueryBuilder;

interface QueryBuilderInterface
{
  /**
   * insertQuery function
   *
   * @return string
   */
  public function insertQuery(): string;

  /**
   * selectQuery function
   *
   * @return string
   */
  public function selectQuery(): string;

  /**
   * updateQuery function
   *
   * @return string
   */
  public function updateQuery(): string;

  /**
   * deleteQuery function
   *
   * @return string
   */
  public function deleteQuery(): string;

  /**
   * searchQuery function
   *
   * @return string
   */
  public function searchQuery(): string;

  /**
   * rawQuery function
   *
   * @return string
   */
  public function rawQuery(): string;

}
