<?php
$title = "Editer Catégorie \"{$category->getName()}\" ";
Auth::requireRole(['admin']);

$errors = [];

if (!empty($_POST)) {
   $categoryModel = new CategoryModel();
   $categoryValidator = new CategoryValidator($_POST, $categoryModel, $category->getID());

   if ($categoryValidator->validate()) {
      if ($categoryModel->editCategory($_POST, $params[0])) {
         header('Location: /admin/categories?updated=1');
      } else {
         header('Location: /admin/categories?noupdated=1');
      }
      exit();
   } else {
      $errors = $categoryValidator->errors();
   }
}

echo "<h2>Editer Catégorie \"{$category->getName()}\"</h2>";
if ($errors) {
   foreach ($errors as $error) {
      foreach ($error as $e) {
         echo "<p>$e </p>>";
      }
   }
}
?>
<div class="form-container">
   <form action="" method="post">
      <input type="text" name="name" value="<?= $category->getName() ?>" required>
      <input type="text" name="slug" value="<?= $category->getSlug() ?>" required>
      <input type="submit" value="Envoyer" style="cursor: pointer">
   </form>
</div>