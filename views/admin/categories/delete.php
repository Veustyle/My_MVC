<?php

if (isset($_POST['slugCategory'])) {
   $categoryModel = new CategoryModel();
   $result = $categoryModel->deleteCategory($_POST['slugCategory']);

   if ($result) {
      header('Location: /admin/categories?deleted=1');
   } else {
      header('Location: /admin/categories?nodeleted=1');
   }
   exit();
}
header('Location: /admin/categories');