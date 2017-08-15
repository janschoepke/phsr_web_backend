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

$app->get('/resources/image.gif', function(ServerRequestInterface $request, ResponseInterface $response) {
    $parameters = $request->getParams();
    if(isset($parameters['user']) && isset($parameters['m']) && isset($parameters['uuid'])) {
        $trackingService = $this->trackingService;
        $trackingService->registerEmailConversion($parameters['m'], $parameters['user'], $parameters['uuid']);
    }

    //Generating tracking pixel to output on clients
    $image =  base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII=');
    $response->write($image);
    return $response->withHeader('Content-Type', FILEINFO_MIME_TYPE);


    //return $response->withStatus(200)->write('hello');
});

$app->group('/phishing', function() use ($app) {

    $app->post('/send-smtp-mail', function(ServerRequestInterface $request, ResponseInterface $response) {

        $body = json_decode($request->getBody());
        $auth = $request->getAttribute('auth');

        $toEmail = htmlspecialchars($body->toEmail);
        $toName = htmlspecialchars($body->toName);
        $fromEmail = htmlspecialchars($body->fromEmail);
        $fromName = htmlspecialchars($body->fromName);
        $subject = htmlspecialchars($body->subject);
        $mailBody = $body->body;
        $smtpHost = htmlspecialchars($body->smtpHost);
        $smtpUser = htmlspecialchars($body->smtpUser);
        $smtpPassword = htmlspecialchars($body->smtpPassword);
        $smtpSecure = htmlspecialchars($body->smtpSecure);
        $smtpPort = htmlspecialchars($body->smtpPort);

        $mailingService = $this->mailingService;
        $mailingService->sendSMTPMail($fromEmail, $fromName, $toEmail, $toName, $subject, $mailBody, $smtpHost, $smtpUser, $smtpPassword, $smtpSecure, $smtpPort);

        $resultData = [
            "success" => "true"
        ];

        return $response->withStatus(200)
            ->write(json_encode($resultData));
    });

    $app->post('/send-mail-to-group', function(ServerRequestInterface $request, ResponseInterface $response) {

        $body = json_decode($request->getBody());
        $auth = $request->getAttribute('auth');

        $groupId = htmlspecialchars($body->groupId);
        $fromEmail = htmlspecialchars($body->fromEmail);
        $fromName = htmlspecialchars($body->fromName);
        $subject = htmlspecialchars($body->subject);
        $mailBody = $body->body;

        $mailingService = $this->mailingService;
        $mailingService->sendMailToGroup($auth, $groupId, $fromEmail, $fromName, $subject, $mailBody);

        $resultData = [
            "success" => "true"
        ];

        return $response->withStatus(200)
            ->write(json_encode($resultData));
    });

    $app->post('/send-mailing-to-group', function(ServerRequestInterface $request, ResponseInterface $response) {

        $body = json_decode($request->getBody());
        $auth = $request->getAttribute('auth');

        $groupId = htmlspecialchars($body->groupId);
        $mailingId = htmlspecialchars($body->mailingId);

        $mailingService = $this->mailingService;
        $mailingService->sendMailingToGroup($auth, $groupId, $mailingId);

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
        $mailBody = $body->body;
        $addTracking = htmlspecialchars($body->addTracking);

        $isSmtp = htmlspecialchars($body->isSmtp);
        $smtpHost = htmlspecialchars($body->smtpHost);
        $smtpUser = htmlspecialchars($body->smtpUser);
        $smtpPassword = htmlspecialchars($body->smtpPassword);
        $smtpSecure = htmlspecialchars($body->smtpSecure);
        $smtpPort = htmlspecialchars($body->smtpPort);

        $mailingService = $this->mailingService;

        $mailingID = null;
        if($isSmtp) {
            $mailingID = $mailingService->addSMTPMailing($auth, $name, $description, $fromEmail, $fromName, $subject, $mailBody, $addTracking, $smtpHost, $smtpUser, $smtpPassword, $smtpSecure, $smtpPort);
        } else {
            $mailingID = $mailingService->addMailing($auth, $name, $description, $fromEmail, $fromName, $subject, $mailBody, $addTracking);
        }

        $resultData = [
            "success" => "true",
            "mailingID" => $mailingID
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
        $newBody = $body->body;
        $newAddTracking = htmlspecialchars($body->addTracking);

        $isSmtp = htmlspecialchars($body->isSmtp);
        $smtpHost = htmlspecialchars($body->smtpHost);
        $smtpUser = htmlspecialchars($body->smtpUser);
        $smtpPassword = htmlspecialchars($body->smtpPassword);
        $smtpSecure = htmlspecialchars($body->smtpSecure);
        $smtpPort = htmlspecialchars($body->smtpPort);

        $mailingService = $this->mailingService;
        $mailingService->editMailing($auth, $mailingID, $newName, $newDescription, $newFromEmail, $newFromName, $newSubject, $newBody, $newAddTracking, $isSmtp, $smtpHost, $smtpUser, $smtpPassword, $smtpSecure, $smtpPort);

        $resultData = [
            "success" => "true"
        ];

        return $response->withStatus(200)
            ->write(json_encode($resultData));
    });

    $app->post('/get-all-sent-mailings', function(ServerRequestInterface $request, ResponseInterface $response) {
        $auth = $request->getAttribute('auth');

        $mailingService = $this->mailingService;
        $mailings = $mailingService->getAllSentMailings($auth);

        $resultData = [
            "success" => "true",
            "mailings" => json_encode($mailings)
        ];

        return $response->withStatus(200)
            ->write(json_encode($resultData));
    });

    $app->post('/get-all-statistics', function(ServerRequestInterface $request, ResponseInterface $response){
        $auth = $request->getAttribute('auth');

        $mailingService = $this->mailingService;
        $statistics = $mailingService->getAllStatistics($auth);

        $resultData = [
            "success" => "true",
            "statistics" => json_encode($statistics)
        ];

        return $response->withStatus(200)
            ->write(json_encode($resultData));
    });

    $app->post('/get-victim-statistics', function(ServerRequestInterface $request, ResponseInterface $response){
        $auth = $request->getAttribute('auth');

        $mailingService = $this->mailingService;
        $statistics = $mailingService->getVictimStatistics($auth);

        $resultData = [
            "success" => "true",
            "statistics" => json_encode($statistics)
        ];

        return $response->withStatus(200)
            ->write(json_encode($resultData));
    });
    $app->post('/get-group-mailing-statistics', function(ServerRequestInterface $request, ResponseInterface $response){
        $auth = $request->getAttribute('auth');

        $mailingService = $this->mailingService;
        $statistics = $mailingService->getGroupMailingStatistics($auth);

        $resultData = [
            "success" => "true",
            "statistics" => json_encode($statistics)
        ];

        return $response->withStatus(200)
            ->write(json_encode($resultData));
    });
})->add($authMiddleware);
