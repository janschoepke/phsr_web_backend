<?php
/**
 * Created by PhpStorm.
 * User: janschopke
 * Date: 01.06.17
 * Time: 15:26
 */
namespace src\routes;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

$app->post('/users/authorize', function(ServerRequestInterface $request, ResponseInterface $response) {
    $body = json_decode($request->getBody());

    $token = htmlspecialchars($body->token);

    try{
        if(!$token) {
            throw new \ApplicationException("Please submit a token.");
        } else {
            $tokenService = $this->tokenService;
            $valid = $tokenService->decodeJWT($token);
            if(!$valid) {
                throw new \ApplicationException("Token invalid.");
            }
        }
    } catch(\ApplicationException $ae) {
        //TODO: Response Service
        return $response->withStatus(403)
            ->write(json_encode(["success" => "false", "code" => $ae->getCode(), "message" => $ae->getMessage()]));
    }

    $resultData = [
        "success" => "true",
        "token" => $token
    ];

    return $response->withStatus(200)
        ->write(json_encode($resultData));

});

$app->post('/users/login', function(ServerRequestInterface $request, ResponseInterface $response) {
    $body = json_decode($request->getBody());

    $email = htmlspecialchars($body->email);
    $password = htmlspecialchars($body->password);

    try{
        if(!$email || !$password) {
            throw new \ApplicationException("Please submit a email/password combination.");
        } else {
            $userService = $this->userService;
            $jwt = $userService->login($email, $password);
        }
    } catch(\ApplicationException $ae) {
        //TODO: Response Service
        return $response->withStatus(403)
            ->write(json_encode(["success" => "false", "code" => $ae->getCode(), "message" => $ae->getMessage()]));
    }

    $resultData = [
        "success" => "true",
        "token" => $jwt
    ];

    return $response->withStatus(200)
        ->write(json_encode($resultData));

});

$app->post('/users/register', function(ServerRequestInterface $request, ResponseInterface $response) {
    $body = json_decode($request->getBody());

    $firstname = htmlspecialchars($body->firstname);
    $lastname = htmlspecialchars($body->lastname);
    $email = htmlspecialchars($body->email);
    $password = htmlspecialchars($body->password);

    try {
        if (!$firstname || !$lastname || !$email || !$password) {
            throw new \ApplicationException("Please submit every required field.");
        } else {
            $userService = $this->userService;
            $userService->register($firstname, $lastname, $email, $password);
        }
    } catch (\ApplicationException $ae) {
        return $response->withStatus(403)
            ->write(json_encode(["success" => "false", "code" => $ae->getCode(), "message" => $ae->getMessage()]));
    }

    $resultData = [
        "success" => "true"
    ];

    return $response->withStatus(200)
        ->write(json_encode($resultData));
});
