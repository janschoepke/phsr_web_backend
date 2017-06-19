<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
        ->withHeader('Access-Control-Allow-Origin', 'http://localhost:8080')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});


$authMiddleware = function($request, $response, $next) {
    $body = json_decode($request->getBody());
    $token = htmlspecialchars($body->token);

    try {
        if(!$token) {
            throw new \ApplicationException("Please submit a token.");
        } else {
            $tokenService = $this->tokenService;
            $valid = (array)$tokenService->decodeJWT($token);
            if (!$valid) {
                throw new \ApplicationException("Token invalid.");
            } else {
                $request = $request->withAttribute('auth', $valid[0]);
                $response = $next($request, $response);
            }
        }

    } catch (\ApplicationException $ae) {
        return $response->withStatus(403)
            ->write(json_encode(["success" => "false", "code" => $ae->getCode(), "message" => $ae->getMessage()]));
    }
    return $response;

};
