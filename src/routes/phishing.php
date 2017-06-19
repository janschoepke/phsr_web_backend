<?php
/**
 * Created by PhpStorm.
 * User: janschopke
 * Date: 15.06.17
 * Time: 13:54
 */

namespace src\routes;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

$app->get('/resources/image.jpg', function(ServerRequestInterface $request, ResponseInterface $response) {
    $allGetVars = $request->getParams();
    echo 'params list: ';
    foreach($allGetVars as $key => $param){
        echo $key . ' => ' . $param;
    }

});

$app->group('/phishing', function() use ($app) {

    $app->post('/send-mail-to-group', function(ServerRequestInterface $request, ResponseInterface $response) {

        $body = json_decode($request->getBody());
        $auth = $request->getAttribute('auth');

        $groupId = htmlspecialchars($body->groupId);
        $fromEmail = htmlspecialchars($body->fromEmail);
        $fromName = htmlspecialchars($body->fromName);
        $subject = htmlspecialchars($body->subject);
        $body = htmlspecialchars($body->body);

        $mailingService = $this->mailingService;
        $mailingService->sendMailToGroup($auth, $groupId, $fromEmail, $fromName, $subject, $body);

        $resultData = [
            "success" => "true"
        ];

        return $response->withStatus(200)
            ->write(json_encode($resultData));
    });


    $app->post('/add-mailing', function(ServerRequestInterface $request, ResponseInterface $response) {

        $body = json_decode($request->getBody());
        $auth = $request->getAttribute('auth');

        $name = htmlspecialchars($body->name);
        $description = htmlspecialchars($body->description);
        $fromEmail = htmlspecialchars($body->fromEmail);
        $fromName = htmlspecialchars($body->fromName);
        $subject = htmlspecialchars($body->subject);
        $body = htmlspecialchars($body->body);
        $addTracking = htmlspecialchars($body->tracking);

        $mailingService = $this->mailingService;
        $mailingService->addMailing($auth, $name, $description, $fromEmail, $fromName, $subject, $body, $addTracking);

        $resultData = [
            "success" => "true"
        ];

        return $response->withStatus(200)
            ->write(json_encode($resultData));
    });

    $app->post('/get-user-mailings', function(ServerRequestInterface $request, ResponseInterface $response) {

        $auth = $request->getAttribute('auth');

        $mailingService = $this->mailingService;
        $userMailings = $mailingService->getUserMailings($auth, false);

        $resultData = [
            "success" => "true",
            "userMailings" => $userMailings
        ];

        return $response->withStatus(200)
            ->write(json_encode($resultData));
    });

    $app->post('/delete-mailing', function(ServerRequestInterface $request, ResponseInterface $response) {

        $body = json_decode($request->getBody());
        $auth = $request->getAttribute('auth');
        $mailingID = htmlspecialchars($body->mailingId);

        $mailingService = $this->mailingService;
        $mailingService->deleteMailing($auth, $mailingID);

        $resultData = [
            "success" => "true"
        ];

        return $response->withStatus(200)
            ->write(json_encode($resultData));
    });

    $app->post('/get-mailing', function(ServerRequestInterface $request, ResponseInterface $response) {

        $body = json_decode($request->getBody());
        $auth = $request->getAttribute('auth');
        $mailingID = htmlspecialchars($body->mailingID);

        $mailingService = $this->mailingService;
        $mailing = $mailingService->getMailing($auth, $mailingID);

        $resultData = [
            "success" => "true",
            "mailing" => $mailing
        ];

        return $response->withStatus(200)
            ->write(json_encode($resultData));
    });

    $app->post('/edit-mailing', function(ServerRequestInterface $request, ResponseInterface $response) {
        $body = json_decode($request->getBody());
        $auth = $request->getAttribute('auth');

        $mailingID = htmlspecialchars($body->mailingID);
        $newName = htmlspecialchars($body->name);
        $newDescription = htmlspecialchars($body->description);
        $newFromEmail = htmlspecialchars($body->fromEmail);
        $newFromName = htmlspecialchars($body->fromName);
        $newSubject = htmlspecialchars($body->subject);
        $newBody = htmlspecialchars($body->body);
        $newAddTracking = htmlspecialchars($body->addTracking);

        $mailingService = $this->mailingService;
        $mailingService->editMailing($auth, $mailingID, $newName, $newDescription, $newFromEmail, $newFromName, $newSubject, $newBody, $newAddTracking);

        $resultData = [
            "success" => "true"
        ];

        return $response->withStatus(200)
            ->write(json_encode($resultData));
    });
})->add($authMiddleware);
