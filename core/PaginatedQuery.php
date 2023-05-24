<?php

final class PaginatedQuery {

   private PDO $pdo;
   private string $query;
   private string $queryCount;
   private int $perPage;

   public function __construct (PDO $pdo, string $query, string $queryCount, int $perPage = 12)
   {
      $this->pdo = $pdo;
      $this->query = $query;
      $this->queryCount = $queryCount;
      $this->perPage = $perPage;
   }

   private function getCurrentPage () : int
   {
      return Model::getPageRedirect();
   }

   private function getPages () : int
   {
      return (int)ceil(($this->pdo->query($this->queryCount)->fetch(PDO::FETCH_NUM)[0]) / $this->perPage);
   }

   public function nextPageLink(string $link) : ?string
   {
      $currentPage = $this->getCurrentPage();
      $pages = $this->getPages();

      if ($currentPage >= $pages) return null;

      $link .= "?page=" . ($currentPage + 1);

      return "<a class='next' href='$link'><button>Page Suivante</button></a>";
   }

   public function previousPageLink(string $link) : ?string
   {
      $currentPage = $this->getCurrentPage();
      if ($currentPage <= 1) return null;
      if ($currentPage > 2) $link .= "?page=" . ($currentPage - 1);

      return "<a class='previous' href='$link'><button>Page Précédente</button></a>";
   }

   public function getItems (string $classMapping) : array {
      $currentPage = $this -> getCurrentPage();

      $offset = $this -> perPage * ( $currentPage - 1 );

      return $this -> pdo -> query($this -> query . " LIMIT $this->perPage OFFSET $offset") -> fetchAll(PDO::FETCH_CLASS, $classMapping);
   }
}