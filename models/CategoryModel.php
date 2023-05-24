<?php

final class CategoryModel extends Model {

   protected string $table = 'categories';

   public function fetchCategory (string $condition = null) : ?Category
   {
      $this->queryBuilder->from('categories');
      if ($condition) {
         $this->queryBuilder->where($condition);
      }
      return $this->queryBuilder->fetch($this->pdo, Category::class) ?: null;
   }

   public function fetchAllCategories (string $condition = null) : ?array
   {
      $this->queryBuilder->from('categories');
      if ($condition) {
         $this->queryBuilder->where($condition);
      }
      return $this->queryBuilder->fetchAll($this->pdo, Category::class) ?: null;
   }

   public function createCategory (array $properties) : bool
   {
      return $this->pdo->exec("INSERT INTO categories (name, slug) VALUES ('{$properties['name']}', '{$properties['slug']}')");
   }

   public function deleteCategory (string $slugArticle) : bool
   {
      return $this->pdo->exec("DELETE FROM 'categories' WHERE slug = '$slugArticle'");
   }
   public function editCategory (array $properties, string $oldSlug) : bool
   {
      return $this->pdo->exec("UPDATE categories set name = '{$properties['name']}', slug = '{$properties['slug']}' WHERE slug = '$oldSlug'");
   }

   public function fetchCategoriesOfArticle (string $slugArticle) : array
   {
      $query = "SELECT c.id, c.name, c.slug FROM categories c JOIN articles_categories ac on c.id = ac.categorie_id JOIN articles a on ac.article_id = a.id WHERE a.slug = '$slugArticle'";

      return $this->pdo->query($query)->fetchAll(PDO::FETCH_CLASS, Category::class);
   }
}