<?php

final class CategoryValidator extends AbstractValidator {

   public function __construct (array $data, CategoryModel $categoryModel = null, $except = null)
   {
      parent ::__construct($data);
      $this->validator->rule('required', ['name', 'slug']);
      $this->validator->rule('lengthBetween', ['name', 'slug'], 3, 30);
      $this->validator->rule('slug', 'slug');

      if ($categoryModel) {
         $this->validator->rule(function($field, $value) use ($categoryModel, $except) {
            if ($except) {
               return !$categoryModel->exists($field, $value, $except);
            } else {
               return !$categoryModel->exists($field, $value);
            }
         }, 'slug', ' est déjà utilisé');
      }
   }
}