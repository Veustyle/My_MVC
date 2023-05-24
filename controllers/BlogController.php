<?php

final class BlogController extends Controller {

   public function index () : void
   {
      $articleModel = new ArticleModel();
      $categoryModel = new CategoryModel();

      [$articles,$paginatedQuery] = $articleModel->fetchArticlesPaginated('articles', Article::class);
      if (empty($articles)) {
         header('Location: /blog/index');
      }

      $categories = $categoryModel->fetchAllCategories();
      foreach ($articles as $article) {
         $c = $categoryModel->fetchCategoriesOfArticle($article->getSlug());
         $article->setCategories($c);
      }

      $this->set('paginatedQuery', $paginatedQuery);
      $this->set('articles', $articles);
      $this->set('categories', $categories);
      $this->render('blog', 'index');
   }

   public function article () : void
   {
      if(!isset($this->variables['params'][0])) {
         header('Location: /blog');
         exit();
      }

      $articleModel = new ArticleModel();
      $article = $articleModel->fetchArticle("slug = '{$this->variables['params'][0]}'");
      if (!$article) {
         header('Location: /blog/index');
         exit();
      }

      $categoryModel = new CategoryModel();
      $categories = $categoryModel->fetchCategoriesOfArticle($article->getSlug());
      $article->setCategories($categories);

      $this->set('article', $article);
      $this->set('categories', $categories);
      $this->render('blog', 'article');
   }

   public function category () : void
   {
      if(!isset($this->variables['params'][0])) {
         header('Location: /blog');
         exit();
      }

      $categoryModel = new CategoryModel();
      $category = $categoryModel->fetchAllCategories("slug = '{$this->variables['params'][0]}'");
      if (!$category) {
         header('Location: /blog/index');
         exit();
      }

      $articleModel = new ArticleModel();
      [$articles, $paginatedQuery] = $articleModel->fetchArticlesPaginatedOfCategory($this->variables['params'][0]);

      foreach ($articles as $article) {
         $c = $categoryModel->fetchCategoriesOfArticle($article->getSlug());
         $article->setCategories($c);
      }

      $this->set('paginatedQuery', $paginatedQuery);
      $this->set('articles', $articles);
      $this->set('category', $category[0]);
      $this->render('blog', 'category');
   }
}
