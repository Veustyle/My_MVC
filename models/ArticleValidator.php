<?php

final class ArticleValidator extends AbstractValidator {

   public function __construct (array $data, ArticleModel $articleModel = null, $except = null)
   {
      parent ::__construct($data);
      $this->validator->rule('required', ['title', 'slug', 'content']);
      $this->validator->rule('lengthBetween', ['title', 'slug'], 3, 30);
      $this->validator->rule('lengthBetween', 'content', 10, 500);
      $this->validator->rule('slug', 'slug');
      $this->validator->rule('image', 'image');

      if ($articleModel) {
         $this->validator->rule(function($field, $value) use ($articleModel, $except) {
            if ($except) {
               return !$articleModel->exists($field, $value, $except);
            } else {
               return !$articleModel->exists($field, $value);
            }
         }, 'slug', ' est déjà utilisé');
      }
   }
}