<?php
/**
 * Created by PhpStorm.
 * User: janschopke
 * Date: 01.06.17
 * Time: 18:09
 */

namespace src;

date_default_timezone_set("UTC");

chdir ('../src/');

require '../vendor/autoload.php';

require '../src/config/database.config.php';

require '../src/exceptions/ApplicationException.php';

// Instantiate the app
$settings = require '../src/config/settings.php';
$app = new \Slim\App($settings);

//Register services
require __DIR__ . '/../src/services.php';

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';



//Load routes
foreach (glob("routes/*.php") as $filename)
{
    require $filename;
}

// Run app
$app->run();
