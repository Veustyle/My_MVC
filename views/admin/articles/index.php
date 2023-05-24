<?php
$title = 'Admin-Articles';
Auth::requireRole(['admin']);
?>

<h2>Page Admin</h2>

<?php
if (isset($_GET['created'])) {
   echo '<p>Article créé</p>';
}
if (isset($_GET['nocreated'])) {
   echo '<p>Il y a eu une erreur dans la création de l\'article</p>';
}
if (isset($_GET['deleted'])) {
   echo '<p>Article Supprimé</p>';
}
if (isset($_GET['nodeleted'])) {
   echo '<p>Il y a eu une erreur dans la suppression de l\'article</p>';
}
if (isset($_GET['updated'])) {
   echo '<p>Article édité</p>';
}
if (isset($_GET['noupdated'])) {
   echo '<p>Il y a eu une erreur dans l\'édition de l\'article</p>';
}
?>

<div class="pagination" style="margin-bottom: 10px">
   <?= $paginatedQuery->previousPageLink('/admin/articles'); ?>
   <?= $paginatedQuery->nextPageLink('/admin/articles'); ?>
</div>

<div class="table-container">
<table class="table">
   <thead>
      <tr>
         <th>Articles</th>
         <th><a href="/admin/new_article">Créer un article</a></th>
      </tr>
   </thead>
   <tbody>
      <?php foreach ($articles as $article) : ?>
         <tr>
            <td><?= $article->getTitle() ?></td>
            <td><a href="/admin/edit_article/<?= $article->getSlug() ?>">Editer</a>
               <form action="/admin/delete_article" method="post" style="display: inline" onsubmit="return confirm('Confirmer ?')">
                  <input type="text" style="display: none" name="slugArticle" value="<?= $article->getSlug() ?>"><input type="submit" value="Supprimer" style="width: auto"></form></td>
         </tr>
      <?php endforeach; ?>
   </tbody>
</table>
</div>