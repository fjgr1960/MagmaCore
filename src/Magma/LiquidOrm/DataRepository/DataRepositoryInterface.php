<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\DataRepository;

interface DataRepositoryInterface
{
  /**
   * find function
   *
   * @param integer $id
   * @return array
   * @throws Throwable
   */
  public function find(int $id): array;

  /**
   * findAll function
   *
   * @return array
   * @throws Throwable
   */
  public function findAll(): array;

  /**
   * findBy function
   *
   * @param array $selectors
   * @param array $conditions
   * @param array $parameters
   * @param array $optional
   * @return array
   * @throws Throwable
   */
  public function findBy(array $selectors, array $conditions, array $parameters, array $optional): array;

  /**
   * findObjectBy function
   *
   * @param array $selectors
   * @param array $conditions
   * @return object
   */
  public function findObjectBy(array $selectors, array $conditions): object;

  /**
   * findOneBy function
   *
   * @param array $conditions
   * @return array
   * @throws Throwable
   */
  public function findOneBy(array $conditions): array;

  /**
   * findBySearch function
   *
   * @param array $selectors
   * @param array $conditions
   * @param array $parameters
   * @param array $optional
   * @return array
   * @throws Throwable
   */
  public function findBySearch(array $selectors, array $conditions, array $parameters, array $optional): array;

  /**
   * findByIdAndDelete function
   *
   * @param array $conditions
   * @return boolean
   * @throws Throwable
   */
  public function findByIdAndDelete(array $conditions): bool;

  /**
   * findByIdAndUpdate function
   *
   * @param integer $id
   * @param array $fields
   * @return boolean
   * @throws Throwable
   */
  public function findByIdAndUpdate(int $id, array $fields): bool;

  /**
   * findWithSearchAndPaging function
   *
   * @param array $args
   * @param object $request
   * @return array
   */
  public function findWithSearchAndPaging(array $args, object $request): array;

  /**
   * findAndReturn function
   *
   * @param integer $id
   * @param array $selectors
   * @return self
   */
  public function findAndReturn(int $id, array $selectors): self;

}
