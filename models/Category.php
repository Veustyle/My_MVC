<?php

final class Category {

   private int $id;
   private string $name;
   private string $slug;

   public function setID (int $id) : self
   {
      $this->id = $id;
      return $this;
   }
   public function getID () : ?string
   {
      return $this->id;
   }
   public function setName (string $name) : self
   {
      $this->name = $name;
      return $this;
   }
   public function GetName () : ?string
   {
      return $this->name;
   }
   public function setSlug (string $slug) : self
   {
      $this->slug = $slug;
      return $this;
   }
   public function GetSlug () : ?string
   {
      return $this->slug;
   }
}