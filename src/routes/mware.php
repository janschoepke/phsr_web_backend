<?php
/**
 * Created by PhpStorm.
 * User: janschopke
 * Date: 15.08.17
 * Time: 09:37
 */

namespace src\routes;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

$app->post('/mware/post-results', function(ServerRequestInterface $request, ResponseInterface $response) {
    $body = json_decode($request->getBody());

    $randomId = htmlspecialchars($body->phsr_campaign_id);
    $timestamp = htmlspecialchars($body->time);
    $computerName = htmlspecialchars($body->computer_name);
    $userName = htmlspecialchars($body->user_name);
    $internalIp = htmlspecialchars($body->internal_ip);
    $externalIp = htmlspecialchars($body->external_ip);
    $osVersion = htmlspecialchars($body->os_version);

    $malwareService = $this->malwareService;
    $malwareService->addCampaignResult($randomId, $timestamp, $computerName, $userName, $internalIp, $externalIp, $osVersion);

    $resultData = [
        "success" => "true"
    ];

    return $response->withStatus(200)
        ->write(json_encode($resultData));
});


$app->group('/mware', function() use ($app) {

    $app->post('/get-user-campaigns', function(ServerRequestInterface $request, ResponseInterface $response) {

        $auth = $request->getAttribute('auth');

        $malwareService = $this->malwareService;
        $userCampaigns = $malwareService->getUserCampaigns($auth, true);

        $resultData = [
            "success" => "true",
            "campaigns" => $userCampaigns
        ];

        return $response->withStatus(200)
            ->write(json_encode($resultData));
    });

    $app->post('/get-campaign', function(ServerRequestInterface $request, ResponseInterface $response) {
        $body = json_decode($request->getBody());
        $auth = $request->getAttribute('auth');

        $campaignID = htmlspecialchars($body->campaignId);

        $malwareService = $this->malwareService;
        $campaign = $malwareService->getCampaign($auth, $campaignID);

        $resultData = [
            "success" => "true",
            "campaign" => $campaign
        ];

        return $response->withStatus(200)
            ->write(json_encode($resultData));
    });

    $app->post('/add-campaign', function(ServerRequestInterface $request, ResponseInterface $response) {
        $body = json_decode($request->getBody());
        $auth = $request->getAttribute('auth');

        $name = htmlspecialchars($body->name);
        $description = htmlspecialchars($body->description);

        $malwareService = $this->malwareService;
        $malwareService->addCampaign($auth, $name, $description);

        $resultData = [
            "success" => "true"
        ];

        return $response->withStatus(200)
            ->write(json_encode($resultData));
    });

    $app->post('/edit-campaign', function(ServerRequestInterface $request, ResponseInterface $response) {
        $body = json_decode($request->getBody());
        $auth = $request->getAttribute('auth');

        $campaignId = htmlspecialchars($body->campaignId);
        $name = htmlspecialchars($body->name);
        $description = htmlspecialchars($body->description);

        $malwareService = $this->malwareService;
        $malwareService->editCampaign($auth, $campaignId, $name, $description);

        $resultData = [
            "success" => "true"
        ];

        return $response->withStatus(200)
            ->write(json_encode($resultData));
    });

    $app->post('/delete-campaign', function(ServerRequestInterface $request, ResponseInterface $response) {
        $body = json_decode($request->getBody());
        $auth = $request->getAttribute('auth');

        $campaignId = htmlspecialchars($body->campaignId);

        $malwareService = $this->malwareService;
        $malwareService->deleteCampaign($auth, $campaignId);

        $resultData = [
            "success" => "true"
        ];

        return $response->withStatus(200)
            ->write(json_encode($resultData));
    });

    $app->post('/get-malware-statistics', function(ServerRequestInterface $request, ResponseInterface $response) {
        $body = json_decode($request->getBody());
        $auth = $request->getAttribute('auth');

        $malwareService = $this->malwareService;
        $statistics = $malwareService->getMalwareStatistics($auth);

        $resultData = [
            "success" => "true",
            "malwareStatistics" => $statistics
        ];

        return $response->withStatus(200)
            ->write(json_encode($resultData));
    });

})->add($authMiddleware);
