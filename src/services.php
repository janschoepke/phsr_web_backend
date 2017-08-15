<?php
/**
 * Created by PhpStorm.
 * User: janschopke
 * Date: 01.06.17
 * Time: 23:34
 */

namespace src;


$container = $app->getContainer();

$container['userService'] = function($container){
    $userService = new services\UserService();
    return $userService;
};

$container['tokenService'] = function($container){
    $tokenService = new services\TokenService();
    return $tokenService;
};

$container['trackingService'] = function($container){
    $trackingService = new services\TrackingService();
    return $trackingService;
};


$container['victimService'] = function($container){
    $victimService = new services\VictimService();
    return $victimService;
};

$container['mailingService'] = function($container){
    $mailingService = new services\MailingService();
    return $mailingService;
};

$container['malwareService'] = function($container){
    $malwareService = new services\MalwareService();
    return $malwareService;
};
