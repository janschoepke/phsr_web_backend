<?php
/**
 * Created by PhpStorm.
 * User: janschopke
 * Date: 04.06.17
 * Time: 20:18
 */


namespace src\routes;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

$app->post('/victim-management/get-groups', function(ServerRequestInterface $request, ResponseInterface $response) {
    $body = json_decode($request->getBody());

    $token = htmlspecialchars($body->token);

    try{
        if(!$token) {
            throw new \ApplicationException("Please submit a token.");
        } else {
            $tokenService = $this->tokenService;
            $valid = (array) $tokenService->decodeJWT($token);
            if(!$valid) {
                throw new \ApplicationException("Token invalid.");
            } else {
                $result = array();
                $i = 0;
                $victimService  = $this->victimService;
                $userGroups = $victimService->getUserGroups($valid[0], true);

                foreach($userGroups as $userGroup) {
                    $result[$i]['Group'] = array("Id" =>$userGroup->getId(), "Name" => $userGroup->getName(), "Description" => $userGroup->getDescription());
                    $result[$i]['Members'] = $victimService->getGroupVictims($valid[0], $userGroup->getId(), true);
                        $i++;
                }
            }
        }
    } catch(\ApplicationException $ae) {
        //TODO: Response Service
        return $response->withStatus(403)
            ->write(json_encode(["success" => "false", "code" => $ae->getCode(), "message" => $ae->getMessage()]));
    }

    $resultData = [
        "success" => "true",
        "allGroups" => json_encode($result)
    ];

    return $response->withStatus(200)
        ->write(json_encode($resultData));

});

$app->post('/victim-management/add-group', function(ServerRequestInterface $request, ResponseInterface $response) {
    $body = json_decode($request->getBody());

    $token = htmlspecialchars($body->token);
    $name = htmlspecialchars($body->name);
    $description = htmlspecialchars($body->description);

    try{
        if(!$token) {
            throw new \ApplicationException("Please submit a token.");
        } else {
            $tokenService = $this->tokenService;
            $valid = (array) $tokenService->decodeJWT($token);
            if(!$valid) {
                throw new \ApplicationException("Token invalid.");
            } else {
                $victimService  = $this->victimService;
                $victimService->addGroup($valid[0], $name, $description);

            }
        }
    } catch(\ApplicationException $ae) {
        //TODO: Response Service
        return $response->withStatus(403)
            ->write(json_encode(["success" => "false", "code" => $ae->getCode(), "message" => $ae->getMessage()]));
    }

    $resultData = [
        "success" => "true"
    ];

    return $response->withStatus(200)
        ->write(json_encode($resultData));

});

//TODO: Name darf nicht leer sein.
$app->post('/victim-management/edit-group', function(ServerRequestInterface $request, ResponseInterface $response) {
    $body = json_decode($request->getBody());

    $token = htmlspecialchars($body->token);
    $groupID = htmlspecialchars($body->groupID);
    $name = htmlspecialchars($body->name);
    $description = htmlspecialchars($body->description);

    try{
        if(!$token) {
            throw new \ApplicationException("Please submit a token.");
        } else {
            $tokenService = $this->tokenService;
            $valid = (array) $tokenService->decodeJWT($token);
            if(!$valid) {
                throw new \ApplicationException("Token invalid.");
            } else {
                $victimService  = $this->victimService;
                $victimService->editGroup($valid[0], $groupID, $name, $description);

            }
        }
    } catch(\ApplicationException $ae) {
        //TODO: Response Service
        return $response->withStatus(403)
            ->write(json_encode(["success" => "false", "code" => $ae->getCode(), "message" => $ae->getMessage()]));
    }

    $resultData = [
        "success" => "true"
    ];

    return $response->withStatus(200)
        ->write(json_encode($resultData));

});

$app->post('/victim-management/get-group', function(ServerRequestInterface $request, ResponseInterface $response) {
    $body = json_decode($request->getBody());

    $token = htmlspecialchars($body->token);
    $groupID = htmlspecialchars($body->groupID);

    try{
        if(!$token) {
            throw new \ApplicationException("Please submit a token.");
        } else {
            $tokenService = $this->tokenService;
            $valid = (array) $tokenService->decodeJWT($token);
            if(!$valid) {
                throw new \ApplicationException("Token invalid.");
            } else {
                $victimService  = $this->victimService;
                $groupData = $victimService->getGroup($valid[0], $groupID);

            }
        }
    } catch(\ApplicationException $ae) {
        //TODO: Response Service
        return $response->withStatus(403)
            ->write(json_encode(["success" => "false", "code" => $ae->getCode(), "message" => $ae->getMessage()]));
    }

    $resultData = [
        "success" => "true",
        "groupData" => $groupData
    ];

    return $response->withStatus(200)
        ->write(json_encode($resultData));

});

$app->post('/victim-management/delete-group', function(ServerRequestInterface $request, ResponseInterface $response) {
    $body = json_decode($request->getBody());

    $token = htmlspecialchars($body->token);
    $groupID = htmlspecialchars($body->groupID);

    try{
        if(!$token) {
            throw new \ApplicationException("Please submit a token.");
        } else {
            $tokenService = $this->tokenService;
            $valid = (array) $tokenService->decodeJWT($token);
            if(!$valid) {
                throw new \ApplicationException("Token invalid.");
            } else {
                $victimService  = $this->victimService;
                $victimService->deleteGroup($valid[0], $groupID);

            }
        }
    } catch(\ApplicationException $ae) {
        //TODO: Response Service
        return $response->withStatus(403)
            ->write(json_encode(["success" => "false", "code" => $ae->getCode(), "message" => $ae->getMessage()]));
    }

    $resultData = [
        "success" => "true"
    ];

    return $response->withStatus(200)
        ->write(json_encode($resultData));

});

//TODO: Check for blank input
$app->post('/victim-management/add-victim', function(ServerRequestInterface $request, ResponseInterface $response) {
    $body = json_decode($request->getBody());

    $token = htmlspecialchars($body->token);
    $name = htmlspecialchars($body->name);
    $lastName = htmlspecialchars($body->lastName);
    $email = htmlspecialchars($body->email);
    $description = htmlspecialchars($body->description);

    try{
        if(!$token) {
            throw new \ApplicationException("Please submit a token.");
        } else {
            $tokenService = $this->tokenService;
            $valid = (array) $tokenService->decodeJWT($token);
            if(!$valid) {
                throw new \ApplicationException("Token invalid.");
            } else {
                $victimService  = $this->victimService;
                $victimService->addVictim($valid[0], $name, $lastName, $email, $description);

            }
        }
    } catch(\ApplicationException $ae) {
        //TODO: Response Service
        return $response->withStatus(403)
            ->write(json_encode(["success" => "false", "code" => $ae->getCode(), "message" => $ae->getMessage()]));
    }

    $resultData = [
        "success" => "true"
    ];

    return $response->withStatus(200)
        ->write(json_encode($resultData));

});

$app->post('/victim-management/add-victim-to-group', function(ServerRequestInterface $request, ResponseInterface $response) {
    $body = json_decode($request->getBody());

    $token = htmlspecialchars($body->token);
    $groupID = htmlspecialchars($body->groupID);
    $victimID = htmlspecialchars($body->victimID);

    try{
        if(!$token) {
            throw new \ApplicationException("Please submit a token.");
        } else {
            $tokenService = $this->tokenService;
            $valid = (array) $tokenService->decodeJWT($token);
            if(!$valid) {
                throw new \ApplicationException("Token invalid.");
            } else {
                $victimService  = $this->victimService;
                $victimService->addVictimToGroup($valid[0], $groupID, $victimID);
            }
        }
    } catch(\ApplicationException $ae) {
        //TODO: Response Service
        return $response->withStatus(403)
            ->write(json_encode(["success" => "false", "code" => $ae->getCode(), "message" => $ae->getMessage()]));
    }

    $resultData = [
        "success" => "true"
    ];

    return $response->withStatus(200)
        ->write(json_encode($resultData));

});


$app->post('/victim-management/get-group-victims', function(ServerRequestInterface $request, ResponseInterface $response) {
    $body = json_decode($request->getBody());

    $token = htmlspecialchars($body->token);
    $groupID = htmlspecialchars($body->groupID);

    try{
        if(!$token) {
            throw new \ApplicationException("Please submit a token.");
        } else {
            $tokenService = $this->tokenService;
            $valid = (array) $tokenService->decodeJWT($token);
            if(!$valid) {
                throw new \ApplicationException("Token invalid.");
            } else {
                $victimService  = $this->victimService;
                $groupVictims = $victimService->getGroupVictims($valid[0], $groupID);
                return $groupVictims;
            }
        }
    } catch(\ApplicationException $ae) {
        //TODO: Response Service
        return $response->withStatus(403)
            ->write(json_encode(["success" => "false", "code" => $ae->getCode(), "message" => $ae->getMessage()]));
    }

    $resultData = [
        "success" => "true"
    ];

    return $response->withStatus(200)
        ->write(json_encode($resultData));

});

$app->post('/victim-management/get-all-victims', function(ServerRequestInterface $request, ResponseInterface $response) {
    $body = json_decode($request->getBody());

    $token = htmlspecialchars($body->token);

    try{
        if(!$token) {
            throw new \ApplicationException("Please submit a token.");
        } else {
            $tokenService = $this->tokenService;
            $valid = (array) $tokenService->decodeJWT($token);
            if(!$valid) {
                throw new \ApplicationException("Token invalid.");
            } else {
                $victimService  = $this->victimService;
                $allVictims = $victimService->getAllVictims($valid[0]);
            }
        }
    } catch(\ApplicationException $ae) {
        //TODO: Response Service
        return $response->withStatus(403)
            ->write(json_encode(["success" => "false", "code" => $ae->getCode(), "message" => $ae->getMessage()]));
    }

    $resultData = [
        "success" => "true",
        "allVictims" => $allVictims
    ];

    return $response->withStatus(200)
        ->write(json_encode($resultData));

});

$app->post('/victim-management/edit-victim', function(ServerRequestInterface $request, ResponseInterface $response) {
    $body = json_decode($request->getBody());

    $token = htmlspecialchars($body->token);
    $victimID = htmlspecialchars($body->victimID);
    $name = htmlspecialchars($body->name);
    $lastName = htmlspecialchars($body->lastName);
    $email = htmlspecialchars($body->email);
    $description = htmlspecialchars($body->description);

    try{
        if(!$token) {
            throw new \ApplicationException("Please submit a token.");
        } else {
            $tokenService = $this->tokenService;
            $valid = (array) $tokenService->decodeJWT($token);
            if(!$valid) {
                throw new \ApplicationException("Token invalid.");
            } else {
                $victimService  = $this->victimService;
                $victimService->editVictim($valid[0], $victimID, $name, $lastName, $email, $description);
            }
        }
    } catch(\ApplicationException $ae) {
        //TODO: Response Service
        return $response->withStatus(403)
            ->write(json_encode(["success" => "false", "code" => $ae->getCode(), "message" => $ae->getMessage()]));
    }

    $resultData = [
        "success" => "true"
    ];

    return $response->withStatus(200)
        ->write(json_encode($resultData));

});

$app->post('/victim-management/remove-victim-from-group', function(ServerRequestInterface $request, ResponseInterface $response) {
    $body = json_decode($request->getBody());

    $token = htmlspecialchars($body->token);
    $groupID = htmlspecialchars($body->groupID);
    $victimID = htmlspecialchars($body->victimID);

    try{
        if(!$token) {
            throw new \ApplicationException("Please submit a token.");
        } else {
            $tokenService = $this->tokenService;
            $valid = (array) $tokenService->decodeJWT($token);
            if(!$valid) {
                throw new \ApplicationException("Token invalid.");
            } else {
                $victimService  = $this->victimService;
                $victimService->removeVictimFromGroup($valid[0], $groupID, $victimID);
            }
        }
    } catch(\ApplicationException $ae) {
        //TODO: Response Service
        return $response->withStatus(403)
            ->write(json_encode(["success" => "false", "code" => $ae->getCode(), "message" => $ae->getMessage()]));
    }

    $resultData = [
        "success" => "true"
    ];

    return $response->withStatus(200)
        ->write(json_encode($resultData));

});

$app->post('/victim-management/delete-victim', function(ServerRequestInterface $request, ResponseInterface $response) {
    $body = json_decode($request->getBody());

    $token = htmlspecialchars($body->token);
    $victimID = htmlspecialchars($body->victimID);

    try{
        if(!$token) {
            throw new \ApplicationException("Please submit a token.");
        } else {
            $tokenService = $this->tokenService;
            $valid = (array) $tokenService->decodeJWT($token);
            if(!$valid) {
                throw new \ApplicationException("Token invalid.");
            } else {
                $victimService  = $this->victimService;
                $victimService->deleteVictim($valid[0], $victimID);
            }
        }
    } catch(\ApplicationException $ae) {
        //TODO: Response Service
        return $response->withStatus(403)
            ->write(json_encode(["success" => "false", "code" => $ae->getCode(), "message" => $ae->getMessage()]));
    }

    $resultData = [
        "success" => "true"
    ];

    return $response->withStatus(200)
        ->write(json_encode($resultData));

});

$app->post('/victim-management/get-victim', function(ServerRequestInterface $request, ResponseInterface $response) {
    $body = json_decode($request->getBody());

    $token = htmlspecialchars($body->token);
    $victimID = htmlspecialchars($body->victimID);

    try{
        if(!$token) {
            throw new \ApplicationException("Please submit a token.");
        } else {
            $tokenService = $this->tokenService;
            $valid = (array) $tokenService->decodeJWT($token);
            if(!$valid) {
                throw new \ApplicationException("Token invalid.");
            } else {
                $victimService  = $this->victimService;
                $currentVictim = $victimService->getVictim($valid[0], $victimID);
            }
        }
    } catch(\ApplicationException $ae) {
        //TODO: Response Service
        return $response->withStatus(403)
            ->write(json_encode(["success" => "false", "code" => $ae->getCode(), "message" => $ae->getMessage()]));
    }

    $resultData = [
        "success" => "true",
        "victimData" => $currentVictim
    ];

    return $response->withStatus(200)
        ->write(json_encode($resultData));

});
