<?php
$title = "Catégorie \"{$category->getName()}\"";
?>

<h2>Category <?= $category->getName() ?></h2>

<div class="pagination">
   <?= $paginatedQuery->previousPageLink("/blog/category/" . $category->getSlug()); ?>
   <?= $paginatedQuery->nextPageLink('/blog/category/' . $category->getSlug()); ?>
</div>

<div class="card-container">
   <?php foreach($articles as $article) : ?>
      <div class="card">
         <p style="line-height: 2em">Catégorie(s) :
            <?php foreach ($article->categories as $c) : ?>
               <a href="/blog/category/<?= $c->getSlug() ?>"><?= $c->getName() ?></a>
            <?php endforeach; ?></p>

         <div class="card-title">
            <p><b><?= $article->getTitle() ?></b></p>
         </div>

         <?php if ($article->getImage() && strlen($article->getImage()) > 3) : ?>
            <div class="card-image">
               <img src="/upload/articles/<?= $article->getImage() ?>_small.jpg" alt="articleImage">
            </div>
         <?php endif; ?>

         <div class="card-content">
            <p><?= substr($article->getContent(), 0, 170).'...'; ?></p>
         </div>

         <div class="card-date">
            <a href="/blog/article/<?= $article->getSlug() ?>" style="padding: 0;"><button class="card-button">Voir Plus</button></a>
            <p><?= $article->getCreatedAt()->format('l j F Y h:i:s') ?></p>
         </div>

      </div>
   <?php endforeach; ?>
</div>