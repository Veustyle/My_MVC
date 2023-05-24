<?php

final class ArticleModel extends Model {

   protected string $table = 'articles';
   protected string $uploadPath = UPLOAD_PATH . DS . 'articles';

   public function fetchArticle (string $condition = null) : ?Article
   {
      $this->queryBuilder->from('articles');
      if ($condition) {
         $this->queryBuilder->where($condition);
      }
      return $this->queryBuilder->fetch($this->pdo, Article::class) ?: null;
   }

   public function createArticle (array $properties) : bool
   {
      try {
         $params['title'] = $properties['title'];
         $params['slug'] = $properties['slug'];
         $params['content'] = $properties['content'];
         $params['date'] = date('Y-m-d H:i:s', strtotime($properties['date']));
         $params['imageName'] = $this->upload($properties['image']['tmp_name']);

         $query = "INSERT INTO articles (title, slug, content, created_at, image) VALUES (:title, :slug, :content, :date, :imageName)";

         $this->pdo->prepare($query)->execute($params);

         if ($properties['categoriesSelected']) {
            $this->attachCategories($properties['categoriesSelected'], $this->pdo->lastInsertId());
         }
         return true;
      } catch (Exception $e) {
         return false;
      }
   }

   public function editArticle (array $properties, Article $article) : bool
   {
      try {
         $params['title'] = $properties['title'];
         $params['slug'] = $properties['slug'];
         $params['content'] = $properties['content'];
         $params['date'] = date('Y-m-d H:i:s', strtotime($properties['date']));
         $params['imageName'] = $this->upload($properties['image']['tmp_name']);
         $params['where'] = $article->getSlug();

         $query = "UPDATE articles set title = :title, slug = :slug, content = :content, created_at = :date, image = :imageName WHERE slug = :where";

         $this->pdo->prepare($query)->execute($params);

         if (!empty($properties['categoriesSelected'])) {
            $this->editAttachCategories($properties['categoriesSelected'], $properties['slug']);
         }
         $this->deleteOldImage($article, $this->uploadPath);
         return true;
      } catch (Exception $e) {
         return false;
      }
   }

   public function deleteArticle (string $slugArticle) : bool
   {
      $article = $this->fetchArticle("slug = '$slugArticle'");
      if ($article) {
         $this->deleteOldImage($article, $this->uploadPath);
      }
      return $this->pdo->exec("DELETE FROM 'articles' WHERE slug = '$slugArticle'");
   }

   public function attachCategories (array $categories, string $lastID) : bool
   {
      try {
         $id = (int)$lastID;
         $categoryModel = new CategoryModel();
         $categoriesToAttach = [];

         foreach ($categories as $category) {
            $categoriesToAttach[] = $categoryModel -> fetchCategory("slug = '$category'");
         }

         foreach ($categoriesToAttach as $category) {
            $categoryModel -> pdo -> exec("INSERT INTO articles_categories (article_id, categorie_id) VALUES ('$id', '{$category->getID()}')");
         }
         return true;
      } catch (Exception $e) {
         return false;
      }
   }
   public function editAttachCategories (array $categories, string $newSlug) : bool
   {
      try {
         $categoryModel = new CategoryModel();

         $categoriesToAttach = [];
         $article = $this->fetchArticle("slug = '$newSlug'");

         foreach ($categories as $category) {
            $categoriesToAttach[] = $categoryModel -> fetchCategory("slug = '$category'");
         }
         $this->pdo->exec("DELETE FROM articles_categories WHERE article_id = '{$article->getID()}'");

         foreach ($categoriesToAttach as $category) {
            $this -> pdo -> exec("INSERT INTO articles_categories (article_id, categorie_id) VALUES ('{$article->getID()}', '{$category->getID()}')");
         }
         return true;
      } catch (Exception $e) {
         return false;
      }
   }

   public function fetchArticlesPaginated (string $table, string $classe) : array
   {
      $query = "SELECT * FROM $table ORDER BY created_at DESC";
      $queryCount = "SELECT count(id) FROM $table";

      $paginatedQuery = new PaginatedQuery($this->pdo, $query, $queryCount);
      $articles = $paginatedQuery->getItems($classe);

      return [$articles, $paginatedQuery];
   }

   public function fetchArticlesPaginatedOfCategory (string $categorySlug) : array
   {
      $query = "SELECT a.id, a.title, a.slug, a.content, a.created_at, a.image FROM articles a JOIN articles_categories ac on a.id = ac.article_id JOIN categories c on ac.categorie_id = c.id WHERE c.slug = '$categorySlug'";

      $queryCount = "SELECT count(title) FROM articles a JOIN articles_categories ac on a.id = ac.article_id JOIN categories c on ac.categorie_id = c.id WHERE c.slug = '$categorySlug'";

      $paginatedQuery = new PaginatedQuery($this->pdo, $query, $queryCount);
      $articles = $paginatedQuery->getItems(Article::class);

      return [$articles, $paginatedQuery];
   }

   public function upload (string $tempPath, Article $article = null) : string
   {
      if ($article) {
         $this->deleteOldImage($article, $this->uploadPath);
      }
      if (strlen($tempPath) < 2) {
         return '';
      }
      if (file_exists($this->uploadPath) === false) {
         mkdir($this->uploadPath, 0777, true);
      }
      $filename = uniqid('', true);
      $manager = new Intervention\Image\ImageManager(['driver' => 'gd']);
      $manager->make($tempPath)->fit(250, 150)->save($this->uploadPath . DS . $filename . '_small.jpg');
      $manager->make($tempPath)->fit(1000, 800)->save($this->uploadPath . DS . $filename . '_large.jpg');

      return $filename;
   }

   public function deleteOldImage (Article $article, string $uploadPath) : void
   {
      if($article->getImage()) {
         $oldFile = $uploadPath . DS . $article->getImage();
         foreach (['_small', '_large'] as $format) {
            if (file_exists($oldFile . $format . '.jpg')) {
               unlink($oldFile . $format . '.jpg');
            }
         }
      }
   }
}