<?php
$title = "Editer Article \"{$article->getTitle()}\" ";
Auth::requireRole(['admin']);
$errors = [];

if (!empty($_POST)) {
   $articleModel = new ArticleModel();
   $articleValidator = new ArticleValidator(array_merge($_POST, $_FILES), $articleModel, $article->getID());

   if ($articleValidator->validate()) {
      if ($articleModel -> editArticle(array_merge($_FILES,$_POST), $article)) {
         header('Location: /admin/articles?updated=1');
      } else {
         header('Location: /admin/articles?noupdated=1');
      }
      exit();
   } else {
      $errors = $articleValidator->errors();
   }
}

echo "<h2>Editer article \"{$article->getTitle()}\"</h2>";
if ($errors) {
   foreach ($errors as $error) {
      foreach ($error as $e) {
         echo "<p>$e </p>";
      }
   }
}
?>
<div class="form-container">
   <form action="" method="post" enctype="multipart/form-data">
      <select name="categoriesSelected[]" multiple>
         <?php foreach ($categories as $category) : ?>
            <option value="<?= $category->getSlug() ?>" <?= in_array($category, $categoriesOfArticle) ? 'selected' : '' ?>><?= $category->getName() ?></option>
         <?php endforeach; ?>
      </select>
      <input type="text" name="title" value="<?= $article->getTitle() ?>" required>
      <input type="text" name="slug" value="<?= $article->getSlug() ?>" required>
      <textarea type="text" name="content" required><?= $article->getContent() ?></textarea>
      <input type="datetime-local" name="date" required>
      <?php if ($article->getImage()) : ?>
         <img src="/upload/articles/<?= $article->getImage() ?>_small.jpg" alt="img" style="width: 250px; align-self: center">
      <?php endif ?>
      <input type="file" name="image">
      <input type="submit" value="Envoyer" style="cursor: pointer">
   </form>
</div>