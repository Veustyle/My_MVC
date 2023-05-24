<?php
$title = 'New Category';
Auth::requireRole(['admin']);

$errors = [];

if (!empty($_POST)) {
   $categoryModel = new CategoryModel();
   $categoryValidator= new CategoryValidator($_POST, $categoryModel);

   if ($categoryValidator->validate()) {
      if ($categoryModel->createCategory($_POST)) {
         header('Location: /admin/categories?created=1');
      } else {
         header('Location: /admin/categories?nocreated=1');
      }
      exit();
   } else {
      $errors = $categoryValidator->errors();
   }
}

echo "<h2>Créer une Catégorie</h2>";
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
      <input type="text" name="name" placeholder="Name" required>
      <input type="text" name="slug" placeholder="Slug" required>
      <input type="submit" value="Envoyer" style="cursor: pointer">
   </form>
</div>