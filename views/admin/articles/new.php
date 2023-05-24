<?php
$title = 'New Article';
Auth::requireRole(['admin']);
$errors = [];

if (!empty($_POST)) {
   $articleModel = new ArticleModel();
   $articleValidator = new ArticleValidator(array_merge($_POST, $_FILES), $articleModel);

   if ($articleValidator->validate()) {
      if ($articleModel->createArticle(array_merge($_POST, $_FILES))) {
         header('Location: /admin/articles?created=1');
      } else {
         header('Location: /admin/articles?nocreated=1');
      }
      exit();
   } else {
      $errors = $articleValidator->errors();
   }
}

echo "<h2>Créer un article</h2>";
if ($errors) {
   foreach ($errors as $error) {
      foreach ($error as $e) {
         echo "<p>$e </p>>";
      }
   }
}
?>
<div class="form-container">
   <form action="" method="post" enctype="multipart/form-data">
      <select name="categoriesSelected[]" id="" multiple>
         <?php foreach ($categories as $category) : ?>
            <option value="<?= $category->getSlug() ?>"><?= $category->getName() ?></option>
         <?php endforeach; ?>
      </select>
      <input type="text" name="title" placeholder="Title" required>
      <input type="text" name="slug" placeholder="Slug" required>
      <p>contenu :</p>
      <textarea type="text" name="content" required></textarea>
      <input type="datetime-local" name="date" placeholder="Date Création" required>
      <input type="file" name="image">
      <input type="submit" value="Envoyer" style="cursor: pointer">
   </form>
</div>