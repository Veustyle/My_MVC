<?php

require ROOT . DS .'models/ArticleModel.php';
require ROOT . DS .'models/CategoryModel.php';
require ROOT . DS . 'models/Article.php';
require ROOT . DS . 'models/Category.php';
require CORE . DS .'QueryBuilder.php';
require CORE . DS . 'PaginatedQuery.php';

class Model {

   private string $db = ROOT . DS . 'db.sqlite';
   public PDO $pdo;
   protected QueryBuilder $queryBuilder;

   public function __construct ()
   {
      $this->queryBuilder = new QueryBuilder();
      $this->pdo = new PDO("sqlite:$this->db", null, null, [
         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS
      ]);
   }

   public function fetchUser (string $username) : ?User
   {
      return $this->pdo->query("SELECT * FROM users WHERE username = '$username'")->fetchAll(PDO::FETCH_CLASS, User::class)[0] ?: null;
   }

   public function exists (string $field, $value, $except = null) : bool
   {
      $sql = "SELECT COUNT(id) FROM $this->table WHERE $field = :field";
      $params['field'] = $value;

      if ($except) {
         $sql .= " AND id != :id";
         $params['id'] = $except;
      }

      $query = $this->pdo->prepare($sql);
      $query->execute($params);
      return (int)$query->fetch(PDO::FETCH_NUM)[0] > 0;
   }

   public static function getPageRedirect () : int {
      if (! isset($_GET['page'])) return 1;

      if ((int)$_GET['page'] <= 1) {
         $uri = explode('?', $_SERVER['REQUEST_URI'])[0];
         unset($_GET['page']);
         $query = http_build_query($_GET);
         if (! empty($query)) {
            $uri .= '?' . $query;
         }
         header('Location: ' . $uri);
         exit();
      }
      return (int)$_GET['page'];
   }

}