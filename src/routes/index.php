<?php
namespace src\routes;


$app->get('/', function() {
    echo "no direct web access on backend.";
});
