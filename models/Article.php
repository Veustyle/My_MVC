<?php

final class Article {

   private int $id;
   private string $title;
   private string $slug;
   private string $content;
   private string $created_at;
   private ?string $image;
   public array $categories = [];

   public function setID (int $id) : self
   {
      $this->id = $id;
      return $this;
   }
   public function getID () : ?int
   {
      return $this->id ?: null;
   }

   public function setTitle (string $title) : self
   {
      $this->title = $title;
      return $this;
   }
   public function getTitle () : ?string
   {
      return $this->title ?: null;
   }

   public function setSlug (string $slug) : self
   {
      $this->slug = $slug;
      return $this;
   }
   public function getSlug () : ?string
   {
      return $this->slug ?: null;
   }

   public function setContent (string $content) : self
   {
      $this->content = $content;
      return $this;
   }
   public function getContent () : ?string
   {
      return $this->content ?: null;
   }

   public function setCreatedAt (string $datetime) : self
   {
      $this->created_at = $datetime;
      return $this;
   }
   public function getCreatedAt () : ?DateTime
   {
      return new DateTime($this->created_at) ?: null;
   }
   public function setImage ($path) : self
   {
      $this->image = $path;
      return $this;
   }
   public function getImage () : ?string
   {
      return $this->image ?: null;
   }

   public function setCategories (array $categories) : self
   {
      foreach ($categories as $category) {
         $this->categories[] = $category;
      }
      return $this;
   }
   public function getCategories () : array
   {
      return $this->categories;
   }
}