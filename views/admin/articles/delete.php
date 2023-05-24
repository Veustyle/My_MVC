<?php

if (isset($_POST['slugArticle'])) {
   $articleModel = new ArticleModel();
   $result = $articleModel->deleteArticle($_POST['slugArticle']);

   if ($result) {
      header('Location: /admin/articles?deleted=1');
   } else {
      header('Location: /admin/articles?nodeleted=1');
   }
   exit();
}
header('Location: /admin/articles');