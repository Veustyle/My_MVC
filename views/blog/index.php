<?php
$title = 'Blog';
?>

<h2>Liste des articles</h2>

<div class="card-container">
   <?= $paginatedQuery->previousPageLink('/blog/index'); ?>
   <?= $paginatedQuery->nextPageLink('/blog/index'); ?>

   <p style="width: 100%; line-height: 2em">Liste des catégories :
   <?php foreach ($categories as $category) : ?>
      <a href="/blog/category/<?= $category->getSlug() ?>"><?= $category->getName() ?></a>
   <?php endforeach ?></p>

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
               <a href="/blog/article/<?= $article->getSlug() ?>" style="padding: 0"><button>Voir Plus</button></a>
               <p><?= $article->getCreatedAt()->format('l j F Y h:i:s') ?></p>
            </div>
         </div>
   <?php endforeach; ?>
</div>