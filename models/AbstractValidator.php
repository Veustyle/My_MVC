<?php
use Valitron\Validator;

abstract class AbstractValidator {

   protected array $data;
   protected Validator $validator;

   public function __construct (array $data)
   {
      $this->data = $data;
      Validator::lang('fr');
      Validator::addRule('image', function ($field, $value, array $params, array $fields) {
         if ($value['size'] === 0) {
            return true;
         }
         $mimes = ['image/jpeg', 'image/png'];
         $finfo = (new finfo())->file($value['tmp_name'], FILEINFO_MIME_TYPE);
         return in_array($finfo, $mimes);
      }, "invalide");
      $this->validator = new Validator($data);
   }

   public function validate () : bool
   {
      return $this->validator->validate();
   }

   public function errors () : array
   {
      return $this->validator->errors();
   }
}