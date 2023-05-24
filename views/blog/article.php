<?php
$title = "Article \"{$article->getTitle()}\" ";
?>

<h2><?= $article->getTitle() ?></h2>

<div class="card-container">
   <div class="card-full">
      <p style="line-height: 2em">Catégorie(s) :
         <?php foreach ($article->categories as $c) : ?>
            <a href="/blog/category/<?= $c->getSlug() ?>"><?= $c->getName() ?></a>
         <?php endforeach; ?></p>

      <div class="card-title">
         <p><b><?= $article->getTitle() ?></b></p>
      </div>
      <?php if ($article->getImage() && strlen($article->getImage()) > 3) : ?>
         <div class="card-image">
            <img src="/upload/articles/<?= $article->getImage() ?>_large.jpg" alt="articleImage" style="width: 80%">
         </div>
      <?php endif; ?>
      <div class="card-content">
         <p><?= $article->getContent() ?></p>
      </div>

      <div class="card-date">
         <p><?= $article->getCreatedAt()->format('l j F Y h:i:s') ?></p>
      </div>

   </div>
</div>