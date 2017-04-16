<?php

namespace app;
use RedBean_Facade as R;
date_default_timezone_set("UTC");

chdir ('../app/');

//Register lib autoloader
require '../composer_modules/autoload.php';

// Prepare app
require 'config/config.env.php';

$app = new \Slim\Slim(array(
	'mode' => $env
));

$app->add(new \Slim\Middleware\SessionCookie(array(
    'expires' => '20 minutes',
    'path' => '/',
    'domain' => null,
    'secure' => false,
    'httponly' => false,
    'name' => 'slim_session',
    'secret' => 'yiaT1G31wpNMGxnhgUlLfM9lc3rfFb',
    'cipher' => MCRYPT_RIJNDAEL_256,
    'cipher_mode' => MCRYPT_MODE_CBC
)));

//Loads all needed subfiles
require 'bootstrap.php';

// Prepare view
$app->view->parserOptions = array(
    'debug' => true,
    'cache' => $app->config('cache'),
);

//Load 404 Route
$app->notFound(function () use ($app) {
	echo '{"status", "404"}';
});

//Run
$app->run();
R::close();
