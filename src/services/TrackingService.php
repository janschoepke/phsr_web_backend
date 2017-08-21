<?php
/**
 * Created by PhpStorm.
 * User: janschopke
 * Date: 20.06.17
 * Time: 20:19
 */

namespace src\services;

use DB\Base\VictimMailingsQuery;
use DB\MailingQuery;
use DB\VictimQuery;
use DB\WebConversion;
use DB\WebVisit;

class TrackingService {

    function registerEmailConversion($mailingId, $victimId, $uuid) {
       $currentVictimMailing = VictimMailingsQuery::create()->filterByMailingId($mailingId)->filterByVictimId($victimId)->filterByUniqueId($uuid)->findOne();
       $currentVictimMailing->setOpened(true);
       $currentVictimMailing->save();
       return true;
    }

    function isRegisteredVictim($currentUser, $userId) {
        if(substr( $userId, 0, 1 ) !== "R") {
            $currentVictim = VictimQuery::create()->filterById($userId)->filterByUser($currentUser)->findOne();
            if (!is_null($currentVictim)) {
                return true;
            }
        }
        return false;
    }

    function registerWebVisit($mailingId, $userId, $url, $browser, $ip, $os, $timestamp, $groupId, $uuid) {
        $currentMailing = MailingQuery::create()->filterById($mailingId)->findOne();
        if(!is_null($currentMailing)) {
            $currentUser = $currentMailing->getUsers()->getFirst();
            if(!is_null($currentUser)) {

                $webVisit = new WebVisit();
                if($this->isRegisteredVictim($currentUser, $userId)) {
                    $webVisit->setVictimId($userId);
                    $victimMailing = VictimMailingsQuery::create()->filterByVictimId($userId)->filterByMailingId($mailingId)->filterByUniqueId($uuid)->findOne();
                    $victimMailing->setClicked(true);
                    $victimMailing->save();
                } else {
                    $webVisit->setUnknownId($userId);
                    $webVisit->setVictimId(null);
                }
                if($groupId != -1) {
                    $webVisit->setGroupId($groupId);
                }
                $webVisit->setUniqueId($uuid);
                $webVisit->setMailing($currentMailing);
                $webVisit->setUrl($url);
                $webVisit->setBrowser($browser);
                $webVisit->setIp($ip);
                $webVisit->setOs($os);
                $webVisit->setTimestamp($timestamp);
                $webVisit->save();
                return true;
            } else {
                throw new \ApplicationException("There is no user with this id.");
                return false;
            }
        } else {
            throw new \ApplicationException("There is no mailing with this id.");
            return false;
        }
    }

    function registerWebConversion($mailingId, $timestamp, $userId, $conversionName, $formData, $groupId, $uuid) {
        $currentMailing = MailingQuery::create()->filterById($mailingId)->findOne();
        if(!is_null($currentMailing)) {
            $currentUser = $currentMailing->getUsers()->getFirst();
            if(!is_null($currentUser)) {

                $webConversion = new WebConversion();
                if($this->isRegisteredVictim($currentUser, $userId)) {
                    $webConversion->setVictimId($userId);
                    $victimMailing = VictimMailingsQuery::create()->filterByVictimId($userId)->filterByMailingId($mailingId)->filterByUniqueId($uuid)->findOne();
                    $victimMailing->setConversioned(true);
                    $victimMailing->save();
                } else {
                    $webConversion->setUnknownId($userId);
                    $webConversion->setVictimId(null);
                }

                if($groupId != -1) {
                    $webConversion->setGroupId($groupId);
                }
                $webConversion->setUniqueId($uuid);
                $webConversion->setMailing($currentMailing);
                $webConversion->setTimestamp($timestamp);
                $webConversion->setConversionName($conversionName);
                $webConversion->setFormData($formData);
                $webConversion->save();
                return true;
            } else {
                throw new \ApplicationException("There is no user with this id.");
                return false;
            }
        } else {
            throw new \ApplicationException("There is no mailing with this id.");
            return false;
        }
    }
}
