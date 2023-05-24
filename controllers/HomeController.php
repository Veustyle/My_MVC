<?php

final class HomeController extends Controller {

   public function index () : void
   {
      $this->render('home', 'index');
   }

   public function login () : void
   {
      $this->render('home', 'login');
   }

   public function logout () : void
   {
      $this->render('home', 'logout');
   }
}