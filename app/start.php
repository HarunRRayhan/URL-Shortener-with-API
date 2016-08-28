<?php

use Slim\Slim;


require '../vendor/autoload.php';

$app = new Slim();

$app->config([
    'baseUrl' => 'http://localhost/shortener/public'
]);

require 'database.php';
require 'routes.php';