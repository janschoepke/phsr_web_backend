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

$app->group('/victim-management', function() use ($app) {
    $app->post('/get-groups', function(ServerRequestInterface $request, ResponseInterface $response) {
        $auth = $request->getAttribute('auth');

        $result = array();
        $i = 0;
        $victimService  = $this->victimService;
        $userGroups = $victimService->getUserGroups($auth, true);

        foreach($userGroups as $userGroup) {
            $result[$i]['Group'] = array("Id" =>$userGroup->getId(), "Name" => $userGroup->getName(), "Description" => $userGroup->getDescription());
            $result[$i]['Members'] = $victimService->getGroupVictims($auth, $userGroup->getId(), true);
            $i++;
        }

        $resultData = [
            "success" => "true",
            "allGroups" => json_encode($result)
        ];

        return $response->withStatus(200)
            ->write(json_encode($resultData));

    });

    $app->post('/add-group', function(ServerRequestInterface $request, ResponseInterface $response) {
        $body = json_decode($request->getBody());
        $auth = $request->getAttribute('auth');

        $name = htmlspecialchars($body->name);
        $description = htmlspecialchars($body->description);

        $victimService  = $this->victimService;
        $victimService->addGroup($auth, $name, $description);

        $resultData = [
            "success" => "true"
        ];

        return $response->withStatus(200)
            ->write(json_encode($resultData));

    });

    $app->post('/edit-group', function(ServerRequestInterface $request, ResponseInterface $response) {
        $body = json_decode($request->getBody());
        $auth = $request->getAttribute('auth');

        $groupID = htmlspecialchars($body->groupID);
        $name = htmlspecialchars($body->name);
        $description = htmlspecialchars($body->description);

        $victimService  = $this->victimService;
        $victimService->editGroup($auth, $groupID, $name, $description);

        $resultData = [
            "success" => "true"
        ];

        return $response->withStatus(200)
            ->write(json_encode($resultData));

    });

    $app->post('/get-group', function(ServerRequestInterface $request, ResponseInterface $response) {
        $body = json_decode($request->getBody());
        $auth = $request->getAttribute('auth');

        $groupID = htmlspecialchars($body->groupID);

        $victimService  = $this->victimService;
        $groupData = $victimService->getGroup($auth, $groupID);

        $resultData = [
            "success" => "true",
            "groupData" => $groupData
        ];

        return $response->withStatus(200)
            ->write(json_encode($resultData));

    });

    $app->post('/delete-group', function(ServerRequestInterface $request, ResponseInterface $response) {
        $body = json_decode($request->getBody());
        $auth = $request->getAttribute('auth');

        $groupID = htmlspecialchars($body->groupID);

        $victimService  = $this->victimService;
        $victimService->deleteGroup($auth, $groupID);

        $resultData = [
            "success" => "true"
        ];

        return $response->withStatus(200)
            ->write(json_encode($resultData));

    });

    $app->post('/add-victim', function(ServerRequestInterface $request, ResponseInterface $response) {
        $body = json_decode($request->getBody());
        $auth = $request->getAttribute('auth');

        $name = htmlspecialchars($body->name);
        $lastName = htmlspecialchars($body->lastName);
        $email = htmlspecialchars($body->email);
        $description = htmlspecialchars($body->description);
        $birthday = htmlspecialchars($body->birthday);
        $gender = htmlspecialchars($body->gender);

        $victimService  = $this->victimService;
        $victimService->addVictim($auth, $name, $lastName, $email, $description, $birthday, $gender);

        $resultData = [
            "success" => "true"
        ];

        return $response->withStatus(200)
            ->write(json_encode($resultData));

    });

    $app->post('/add-victim-to-group', function(ServerRequestInterface $request, ResponseInterface $response) {
        $body = json_decode($request->getBody());
        $auth = $request->getAttribute('auth');

        $groupID = htmlspecialchars($body->groupID);
        $victimID = htmlspecialchars($body->victimID);

        $victimService  = $this->victimService;
        $victimService->addVictimToGroup($auth, $groupID, $victimID);

        $resultData = [
            "success" => "true"
        ];

        return $response->withStatus(200)
            ->write(json_encode($resultData));

    });


    $app->post('/get-group-victims', function(ServerRequestInterface $request, ResponseInterface $response) {

        $body = json_decode($request->getBody());
        $auth = $request->getAttribute('auth');

        $groupID = htmlspecialchars($body->groupID);

        $victimService  = $this->victimService;
        $groupVictims = $victimService->getGroupVictims($auth, $groupID);
        $resultData = [
            "success" => "true",
            "groupVictims" => $groupVictims
        ];

        return $response->withStatus(200)
            ->write(json_encode($resultData));

    });

    $app->post('/get-all-victims', function(ServerRequestInterface $request, ResponseInterface $response) {
        $body = json_decode($request->getBody());
        $auth = $request->getAttribute('auth');

        $token = htmlspecialchars($body->token);

        $victimService  = $this->victimService;
        $allVictims = $victimService->getAllVictims($auth);

        $resultData = [
            "success" => "true",
            "allVictims" => $allVictims
        ];

        return $response->withStatus(200)
            ->write(json_encode($resultData));

    });

    $app->post('/edit-victim', function(ServerRequestInterface $request, ResponseInterface $response) {
        $body = json_decode($request->getBody());
        $auth = $request->getAttribute('auth');

        $victimID = htmlspecialchars($body->victimID);
        $name = htmlspecialchars($body->name);
        $lastName = htmlspecialchars($body->lastName);
        $email = htmlspecialchars($body->email);
        $description = htmlspecialchars($body->description);
        $birthday = htmlspecialchars($body->birthday);
        $gender = htmlspecialchars($body->gender);

        $victimService  = $this->victimService;
        $victimService->editVictim($auth, $victimID, $name, $lastName, $email, $description, $birthday, $gender);

        $resultData = [
            "success" => "true"
        ];

        return $response->withStatus(200)
            ->write(json_encode($resultData));

    });

    $app->post('/remove-victim-from-group', function(ServerRequestInterface $request, ResponseInterface $response) {
        $body = json_decode($request->getBody());
        $auth = $request->getAttribute('auth');

        $groupID = htmlspecialchars($body->groupID);
        $victimID = htmlspecialchars($body->victimID);

        $victimService  = $this->victimService;
        $victimService->removeVictimFromGroup($auth, $groupID, $victimID);

        $resultData = [
            "success" => "true"
        ];

        return $response->withStatus(200)
            ->write(json_encode($resultData));

    });

    $app->post('/delete-victim', function(ServerRequestInterface $request, ResponseInterface $response) {
        $body = json_decode($request->getBody());
        $auth = $request->getAttribute('auth');

        $victimID = htmlspecialchars($body->victimID);

        $victimService  = $this->victimService;
        $victimService->deleteVictim($auth, $victimID);

        $resultData = [
            "success" => "true"
        ];

        return $response->withStatus(200)
            ->write(json_encode($resultData));

    });

    $app->post('/get-victim', function(ServerRequestInterface $request, ResponseInterface $response) {
        $body = json_decode($request->getBody());
        $auth = $request->getAttribute('auth');

        $victimID = htmlspecialchars($body->victimID);

        $victimService  = $this->victimService;
        $currentVictim = $victimService->getVictim($auth, $victimID);

        $resultData = [
            "success" => "true",
            "victimData" => $currentVictim
        ];

        return $response->withStatus(200)
            ->write(json_encode($resultData));

    });
})->add($authMiddleware);


