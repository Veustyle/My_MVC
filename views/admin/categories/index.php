<?php
$title = 'Admin-Categories';
Auth::requireRole(['admin']);
?>

<h2>Page Admin</h2>

<?php
if (isset($_GET['created'])) {
   echo '<p>Catégorie créée</p>';
}
if (isset($_GET['nocreated'])) {
   echo '<p>Il y a eu une erreur dans la création de la catégorie</p>';
}
if (isset($_GET['deleted'])) {
   echo '<p>Catégorie Supprimé</p>';
}
if (isset($_GET['nodeleted'])) {
   echo '<p>Il y a eu une erreur dans la suppression de la catégorie</p>';
}
if (isset($_GET['updated'])) {
   echo '<p>Catégorie édité</p>';
}
if (isset($_GET['noupdated'])) {
   echo '<p>Il y a eu une erreur dans l\'édition de la catégorie</p>';
}
?>

<div class="table-container">
   <table class="table">
      <thead>
         <tr>
            <th>Catégories</th>
            <th><a href="/admin/new_category">Créer une catégorie</a></th>
         </tr>
      </thead>
      <tbody>
      <?php foreach ($categories as $category) : ?>
         <tr>
            <td><?= $category->getName() ?></td>
            <td><a href="/admin/edit_category/<?= $category->getSlug() ?>">Editer</a>
               <form action="/admin/delete_category/<?= $category->getSlug() ?>" method="post" style="display: inline" onsubmit="return confirm('Confirmer ?')">
                  <input type="text" name="slugCategory" value="<?= $category->getSlug() ?>" style="display: none">
                  <input type="submit" value="Supprimer" style="width: auto"></form></td>
         </tr>
      <?php endforeach; ?>
      </tbody>
   </table>
</div>