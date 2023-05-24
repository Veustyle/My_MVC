<?php
$title = 'Login';

if (!empty($_POST)) {
   Auth::login($_POST['username'], $_POST['password']);
}

if (isset($_GET['error'])) {
   echo '<p>Il y a eu une erreur</p>';
}
?>

<h2>Connexion</h2>

<div class="form-container">
   <form action="" method="post">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="submit" value="Se Connecter" style="cursor: pointer;">
   </form>
</div>