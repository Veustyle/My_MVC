<?php

final class AdminController extends Controller {

   protected string $layout = 'admin';

// ARTICLES
   public function articles () : void
   {
      $articleModel = new ArticleModel();

      [$articles, $paginatedQuery] = $articleModel->fetchArticlesPaginated('articles', Article::class);

      $this->set('paginatedQuery', $paginatedQuery);
      $this->set('articles', $articles);
      $this->render('admin/articles', 'index');
   }
   public function new_article () : void
   {
      $categoryModel = new CategoryModel();
      $categories = $categoryModel->fetchAllCategories();
      $this->set('categories', $categories);

      $this->render('admin/articles', 'new');
   }
   public function delete_article () : void
   {
      $this->render('admin/articles', 'delete');
   }
   public function edit_article () : void
   {
      $articleModel = new ArticleModel();
      $categoryModel = new CategoryModel();

      $article = $articleModel->fetchArticle("slug = '{$this->variables['params'][0]}'");

      $categories = $categoryModel->fetchAllCategories();
      $categoriesOfArticle = $categoryModel->fetchCategoriesOfArticle($article->getSlug());

      $this->set('categoriesOfArticle', $categoriesOfArticle);
      $this->set('categories', $categories);
      $this->set('article', $article);
      $this->render('admin/articles', 'edit');
   }

// CATEGORIES
   public function categories () : void
   {
      $categoryModel = new CategoryModel();

      $categories = $categoryModel->fetchAllCategories();

      $this->set('categories', $categories);
      $this->render('admin/categories', 'index');
   }
   public function new_category () : void
   {
      $this->render('admin/categories', 'new');
   }
   public function delete_category () : void
   {
      $this->render('admin/categories', 'delete');
   }
   public function edit_category () : void
   {
      $categoryModel = new CategoryModel();
      $category = $categoryModel->fetchCategory("slug = '{$this->variables['params'][0]}'");

      $this->set('category', $category);
      $this->render('admin/categories', 'edit');
   }
}