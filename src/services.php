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

$container['responseService'] = function($container){
    $responseService = new services\ResponseService();
    return $responseService;
};

$container['tokenService'] = function($container){
    $tokenService = new services\TokenService();
    return $tokenService;
};

$container['victimService'] = function($container){
    $victimService = new services\VictimService();
    return $victimService;
};
