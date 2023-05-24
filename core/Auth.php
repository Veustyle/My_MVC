<?php

require CORE . DS . 'User.php';

final class Auth {

   public static function login(string $username, string $password) : void
   {
      $model = new Model();
      $user = $model->fetchUser($username);

      if (!$user || !password_verify($password, $user->getPassword())) {
         header('Location: /home/login?error=1');
         exit();
      }

      $_SESSION['auth'] = $user->getRole();
      header('Location: /home');
      exit();
   }

   public static function requireRole (array $roles) : void
   {
      if (!in_array($_SESSION['auth'], $roles)) {
         header('Location: /home/login');
         exit();
      }
   }
}