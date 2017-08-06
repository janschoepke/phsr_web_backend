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
    if(isset($parameters['user']) && isset($parameters['m'])) {
        $trackingService = $this->trackingService;
        $trackingService->registerEmailConversion($parameters['m'], $parameters['user']);
    }

    //Generating tracking pixel to output on clients

    $image =  base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII=');
    //$image =  base64_decode('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');
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
})->add($authMiddleware);
