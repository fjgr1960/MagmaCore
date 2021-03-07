<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\QueryBuilder;

use Magma\LiquidOrm\QueryBuilder\Exception\QueryBuilderInvalidArgumentException;

class QueryBuilder implements QueryBuilderInterface
{
  /** properties */
  protected const QUERY_TYPES = ['insert', 'select', 'update', 'delete', 'search', 'raw'];
  protected const SQL_DEFAULT = [
    'conditions' => [],
    'selectors' => [],
    'replace' => false,
    'distinct' => false,
    'from' => [],
    'where' => null,
    'and' => [],
    'or' => [],
    'orderBy' => [],
    'fields' => [],
    'primaryKey' => '',
    'table' => '',
    'type' => '',
    'raw' => '',
  ];
  protected string $sqlQuery = '';
  protected array $key;

  /**
   * Class constructor
   * 
   * @return void
   */
  public function __construct()
  {}

  /**
   * buildQuery function
   *
   * @param array $args
   * @return self
   * @throws QueryBuilderInvalidArgumentException
   */
  public function buildQuery(array $args = []): self
  {
    if (count($args) < 0) {
      throw new QueryBuilderInvalidArgumentException();
    }
    $this->key = array_merge(self::SQL_DEFAULT, $args);
    return $this;
  }

  /**
   * isQueryTypeValid function
   *
   * @param string $type
   * @return boolean
   */
  private function isQueryTypeValid(string $type): bool
  {
    if (in_array($type, self::QUERY_TYPES)) {
      return true;
    }
    return false;
  }

  /** @inheritDoc */
  public function insertQuery(): string
  {
    if ($this->isQueryTypeValid('insert')) {
      if (is_array($this->key['fields']) && count($this->key['fields']) > 0) {
        $fields = array_keys($this->key['fields']);
        $values = array(implode(', ', $fields), ':'.implode(', :', $fields));
        $this->sqlQuery = "INSERT INTO $this->key['table'] ($values[0]) VALUES ($values[1])";
        return $this->sqlQuery;
      }
    }
    return false;
  }

  /** @inheritDoc */
  public function selectQuery(): string
  {
    if ($this->isQueryTypeValid('select')) {
      $selectors = !empty($this->key['selectors']) ? implode(', ', $this->key['selectors']) : '*';
      $this->sqlQuery = "SELECT $selectors FROM $this->key['table']";
      $this->sqlQuery = $this->hasConditions();
      return $this->sqlQuery;
    }
    return false;
  }

  /** @inheritDoc */
  public function updateQuery(): string
  {
    if (!$this->isQueryTypeValid('update')) {
      if (is_array($this->key['fields']) && count($this->key['fields']) > 0) {
        $values = '';
        foreach ($this->key['fields'] as $field) {
          if ($field !== $this->key['primaryKey']) {
            $values .= "$field = :$field, ";
          }
        }
        $values = substr_replace($values, '', -2);
        if (count($this->key['fields']) > 0) {
          $this->sqlQuery = "UPDATE $this->key['table'] SET $values WHERE $this->key['primaryKey'] = :$this->key['primaryKey'] LIMIT 1";
          if (isset($this->key['primaryKey']) && $this->key['primaryKey'] === '0') {
            unset($this->key['primaryKey']);
            $this->sqlQuery = "UPDATE $this->key['table'] SET $values";
          }
        }
        return $this->sqlQuery;
      }
    }
    return false;
  }

  /** @inheritDoc */
  public function deleteQuery(): string
  {
    if ($this->isQueryTypeValid('delete')) {
      $index = array_keys($this->key['conditions']);
      $this->sqlQuery = "DELETE FROM $this->key['table'] WHERE $index[0] = :$index[0] LIMIT 1";
      $bulkDelete = array_values($this->key['fields']);
      if (is_array($bulkDelete) && count($bulkDelete) > 1) {
        for ($i=0; $i < count($bulkDelete); $i++) {
          $this->sqlQuery = "DELETE FROM $this->key['table'] WHERE $index[0] = :$index[0]";
        }
      }
      return $this->sqlQuery;
    }
    return false;
  }

  /** @inheritDoc */
  public function searchQuery(): string
  {
    return '';
  }

  /** @inheritDoc */
  public function rawQuery(): string
  {
    return '';
  }

  /**
   * hasConditions function
   *
   * @return string
   */
  private function hasConditions(): string
  {
    if (isset($this->key['conditions']) && !empty($this->key['conditions'])) {
      if (is_array($this->key['conditions'])) {
        $sort = [];
        foreach (array_keys($this->key['conditions']) as $key => $where) {
          if (isset($where) && !empty($where)) {
            $sort[] .= "$where = :$where";
          }
        }
        if (count($this->key['conditions'] > 0)) {
          $conditons = implode('AND ', $sort);
          $this->sqlQuery .= " WHERE $conditons";
        }
      }
    }
    else if (empty($this->key['conditions'])) {
      $this->sqlQuery .= " WHERE 1";
    }

    if (isset($this->key['orderBy']) && !empty($this->key['orderBy'])) {
      $this->sqlQuery .= " ORDER BY $this->key['orderBy'] ";
    }

    if (isset($this->key['limit']) && $this->key['offset'] != -1) {
      $this->sqlQuery .= " LIMIT :offset :limit";
    }

    return $this->sqlQuery;
  }

}
