<?php
/**
 * Created by PhpStorm.
 * User: janschopke
 * Date: 20.06.17
 * Time: 20:18
 */

namespace src\routes;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;


$app->group('/tracking', function() use ($app) {

    $app->post('/get-ip-address', function(ServerRequestInterface $request, ResponseInterface $response) {
        $ipAddress = $request->getAttribute('ip_address');

        $resultData = [
            "success" => "true",
            "ip" => $ipAddress
        ];

        return $response->withStatus(200)
            ->write(json_encode($resultData));
    });

    $app->post('/webvisit', function (ServerRequestInterface $request, ResponseInterface $response) {

        $body = json_decode($request->getBody());

        $mailingId = htmlspecialchars($body->mailingid);
        $groupId = htmlspecialchars($body->groupID);
        $userId = htmlspecialchars($body->userID);
        $url = htmlspecialchars($body->url);
        $browser = htmlspecialchars($body->browser);
        $ip = htmlspecialchars($body->ip);
        $os = htmlspecialchars($body->os);
        $timestamp = htmlspecialchars($body->timestamp);
        $uuid = htmlspecialchars($body->uuid);

        try {
            $trackingService = $this->trackingService;
            $trackingService->registerWebVisit($mailingId, $userId, $url, $browser, $ip, $os, $timestamp, $groupId, $uuid);
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

    $app->post('/webconversion', function (ServerRequestInterface $request, ResponseInterface $response) {

        $body = json_decode($request->getBody());

        $mailingId = htmlspecialchars($body->mailingid);
        $groupId = htmlspecialchars($body->groupID);
        $timestamp = htmlspecialchars($body->timestamp);
        $userId = htmlspecialchars($body->userID);
        $conversionName = htmlspecialchars($body->conversion);
        $formData = $body->fieldData;
        $uuid = htmlspecialchars($body->uuid);

        try {
            $trackingService = $this->trackingService;
            $trackingService->registerWebConversion($mailingId, $timestamp, $userId, $conversionName, $formData, $groupId, $uuid);
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
});
