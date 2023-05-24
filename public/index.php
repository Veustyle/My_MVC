<?php
session_start();

define('WEBROOT', dirname(__FILE__));
define('ROOT', dirname(WEBROOT));

const DS = DIRECTORY_SEPARATOR;
const CORE = ROOT . DS . 'core';
const UPLOAD_PATH = WEBROOT . DS . 'upload';

require CORE . DS . 'Routeur.php';
require CORE . DS . 'Controller.php';
require CORE . DS . 'Auth.php';
require ROOT . DS . 'vendor/autoload.php';
require ROOT . DS . 'models/AbstractValidator.php';
require ROOT . DS . 'models/ArticleValidator.php';
require ROOT . DS . 'models/CategoryValidator.php';

new Routeur();
Model::getPageRedirect();