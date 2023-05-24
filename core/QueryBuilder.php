<?php

final class QueryBuilder {

   private array $selects = [];
   private string $from;
   private ?string $orderBy = null;
   private string $direction;
   private ?string $limite = null;
   private ?string $offset = null;
   private ?string $where = null;
   private array $params = [];
   private string $query;

   public function toSQL() : string
   {
      $this->query = "SELECT";
      if (count($this->selects) === 0) {
         $this->query .= " *";
      } else {
         $s = implode( ", ", $this->selects);
         $this->query .= " $s";
      }

      $this->addConditions();

      return $this->query;
   }

   public function fetch (PDO $pdo, string $classe)
   {
      $this->query = "SELECT *";

      $this->addConditions();

      $statement = $pdo->prepare($this->query);
      $statement->setFetchMode(PDO::FETCH_CLASS, $classe);
      $statement->execute($this->params);
      return $statement->fetch() ?: null;
   }

   public function fetchAll (PDO $pdo, string $classe) : ?array
   {
      $query = $pdo->prepare($this->toSQL());
      $query->execute($this->params);
      return $query->fetchAll(PDO::FETCH_CLASS, $classe) ?: null;
   }

   public function count (PDO $pdo) : ?int {
      $this->query = "SELECT COUNT(id) as count";

      $this->addConditions();

      $statement = $pdo->prepare($this->query);
      $statement->execute($this->params);
      return $statement->fetch()['count'] ?: null;
   }

   private function addConditions () : void
   {
      $this->query .= " FROM $this->from";

      if ($this->where !== null) {
         $this->query .= " WHERE $this->where";
      }
      if ($this->orderBy !== null) {
         $this->query .= " ORDER BY $this->orderBy $this->direction";
      }
      if ($this->limite !== null) {
         $this->query .= " LIMIT $this->limite";
      }
      if ($this->offset !== null) {
         $this->query .= " OFFSET $this->offset";
      }
   }

   public function select (...$selects) : self {
      foreach ($selects as $select) {
         if (is_array($select)) {
            foreach ($select as $sel) {
               $this->selects[] = $sel;
            }
         } else {
            $this->selects[] = $select;
         }
      }
      return $this;
   }

   public function insert(string $table, array $columns, array $values) : string
   {
      if (count($columns) <= 1) {
         $this->columns = implode('', $columns);
      } else {
         $this->columns = implode(', ', $columns);
      }
      if (count($values) <= 1) {
         $this->values = implode('', $values);
      } else {
         $this->values = implode("', '", $values);
      }

      return "INSERT INTO $table ($this->columns) VALUES ('$this->values')";
   }

   public function delete(string $table, $conditions = null) : string
   {
      if (!$conditions) {
         return "DELETE FROM $table";
      } else {
         return "DELETE FROM $table WHERE $conditions";
      }
   }

   public function from (string $table, string $alias = null) : self
   {
      $this->from = "$table";
      if ($alias) {
         $this->from .= " $alias";
      }
      return $this;
   }

   public function where (string $condition) : self {
      $this->where = $condition;
      return $this;
   }

   public function limit(int $limite) : self {
      $this->limite = $limite;
      return $this;
   }

   public function offset(int $offset) : self {
      $this->offset = $offset;
      return $this;
   }

   public function OrderBy (string $orderBy, string $direction) : self
   {
      $this->direction = $direction;

      if ($this->orderBy !== null) {
         $this->orderBy .= ", $orderBy";
         return $this;
      }
      $this->orderBy =  $orderBy;

      return $this;
   }

   public function setParam (string $param, $value) : self {
      $this->params[$param] = $value;
      return $this;
   }
}