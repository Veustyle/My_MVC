<?php

$_SESSION['auth'] = '';
session_destroy();

header('Location: /home');
exit();