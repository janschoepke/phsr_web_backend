<?php

use RedBean_Facade as R;

if($env == 'development'){
    R::setup('mysql:host=127.0.0.1;dbname=master_thesis','root','root');
}

$app->configureMode('development', function () use ($app) {
    $app->config(array(
        'log.enabled' => true,
        'debug' => true,
        'cache' => false,
    ));
});
