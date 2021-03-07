<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\DataRepository;

use Magma\LiquidOrm\EntityManager\EntityManager;
use Magma\LiquidOrm\DataRepository\Exception\DataRepositoryInvalidArgumentException;
use Throwable;

class DataRepository implements DataRepositoryInterface
{
  /**
   * Class constructor
   * 
   * @param EntityManager $em
   * @return void
   */
  public function __construct(
    protected EntityManager $em
  )
  {}

  /**
   * isArray function
   *
   * @param mixed $conditions
   * @return void
   * @throws DataRepositoryInvalidArgumentException
   */
  private function isArray(mixed $conditions): void
  {
    if (!is_array($conditions)) {
      throw new DataRepositoryInvalidArgumentException(
        'The argument supplied is not an array!'
      );
    }
  }

  /**
   * isEmpty function
   *
   * @param integer $id
   * @return void
   * @throws DataRepositoryInvalidArgumentException
   */
  private function isEmpty(int $id): void
  {
    if (!empty($id)) {
      throw new DataRepositoryInvalidArgumentException(
        'The argument supplied must not be empty!'
      );
    }
  }

  /** @inheritDoc */
  public function find(int $id): array
  {
    $this->isEmpty($id);
    try {
      return $this->findOneBy(['id' => $id]);
    }
    catch (Throwable $th) {
      throw $th;
    }
  }

  /** @inheritDoc */
  public function findAll(): array
  {
    try {
      return $this->em->getCrud()->read();
    }
    catch (Throwable $th) {
      throw $th;
    }
  }

  /** @inheritDoc */
  public function findBy(array $selectors = [], array $conditions = [], array $parameters = [], array $optional = []): array
  {
    try {
      return $this->em->getCrud()->read($selectors, $conditions, $parameters, $optional);
    }
    catch (Throwable $th) {
      throw $th;
    }
  }

  /** @inheritDoc */
  public function findObjectBy(array $selectors = [], array $conditions = []): object
  {
    return $this;
  }

  /** @inheritDoc */
  public function findOneBy(array $conditions): array
  {
    $this->isArray($conditions);
    try {
      return $this->em->getCrud()->read($conditions);
    }
    catch (Throwable $th) {
      throw $th;
    }
  }

  /** @inheritDoc */
  public function findBySearch(array $selectors = [], array $conditions = [], array $parameters = [], array $optional = []): array
  {
    $this->isArray($conditions);
    try {
      return $this->em->getCrud()->search($selectors, $conditions, $parameters, $optional);
    }
    catch (Throwable $th) {
      throw $th;
    }
  }

  /** @inheritDoc */
  public function findByIdAndDelete(array $conditions): bool
  {
    $this->isArray($conditions);
    try {
      $result = $this->findOneBy($conditions);
      if (!is_null($result) && count($result) > 0) {
        return $this->em->getCrud()->delete($conditions);
      }
    }
    catch (Throwable $th) {
      throw $th;
    }
  }

  /** @inheritDoc */
  public function findByIdAndUpdate(int $id, array $fields = []): bool
  {
    $this->isArray($fields);
    try {
      $result = $this->findOneBy([$this->em->getCrud()->getSchemaID() => $id]);
      if (!is_null($result) && count($result) > 0) {
        $params = !empty($fields) ? array_merge([$this->em->getCrud()->getSchemaID() => $id], $fields) : $fields;
        return $this->em->getCrud()->update($params, $this->em->getCrud()->getSchemaID());
      }
    }
    catch (Throwable $th) {
      throw $th;
    }
  }

  /** @inheritDoc */
  public function findWithSearchAndPaging(array $args, object $request): array
  {
    return [];
  }

  /** @inheritDoc */
  public function findAndReturn(int $id, array $selectors = []): self
  {
    return $this;
  }

}
