<?php
namespace app\routes;

use RedBean_Facade as R;

$app->get('/', function() {
    echo "no direct web access on backend.";
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
