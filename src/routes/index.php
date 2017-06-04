<?php
namespace src\routes;


$app->get('/', function() {
    echo "no direct web access on backend.";
});

$app->get('/ping', function() {
    echo phpversion();
});

$app->get('/database', function() use($app) {
   $users = \DB\UserQuery::create()->find();
   var_dump($users->count());
});

$app->post('/client/executed', function() use ($app) {
	$body = json_decode($app->request()->getBody());

    $execution = R::dispense('malwareexecution');
    $execution->time = $body->time;
    $execution->computer_name = $body->computer_name;
    $execution->user_name = $body->user_name;
    $execution->internal_ip = $body->internal_ip;
    $execution->external_ip = $body->external_ip;
    $execution->os_version = $body->os_version;
    $id = R::store($execution);

    return $app->response;
});

