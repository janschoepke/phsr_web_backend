<?php
/**
 * Created by PhpStorm.
 * User: janschopke
 * Date: 15.06.17
 * Time: 13:46
 */

namespace src\services;


use DB\MailingQuery;
use DB\VictimMailingsQuery;
use DB\GroupMailingsQuery;
use DB\Mailing;
use DB\UserMailingsQuery;
use DB\UserQuery;
use PHPMailer\PHPMailer\PHPMailer;

class MailingService
{

    function sendMail($fromEmail, $fromName, $toEmail, $toName, $subject, $body) {
        trigger_error("Deprecated function called.", E_USER_NOTICE);
        $mail = new PHPMailer;

        $mail->setFrom($fromEmail, $fromName);
        $mail->addAddress($toEmail, $toName);

        $mail->isHTML(true);

        $mail->Subject = $subject;
        $mail->Body    = $body;

        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
        return true;

    }

    function sendMailToGroup($userMail, $groupId, $fromEmail, $fromName, $subject, $body) {
        $victimService = new VictimService();
        $victims = $victimService->getGroupVictims($userMail, $groupId, true);

        foreach ($victims as $victim) {
            var_dump($victim);
            $this->sendMail($fromEmail, $fromName, $victim['Email'], $victim['Firstname'] . ' ' . $victim['Lastname'], $subject, $body);
        }

    }

    function addMailing($userMail, $name, $description, $fromEmail, $fromName, $subject, $body, $addTracking) {
        $currentUser = UserQuery::create()->filterByEmail($userMail)->findOne();
        if(!is_null($currentUser)) {
            $mailing = new Mailing();
            $mailing->setName($name);
            $mailing->setDescription($description);
            $mailing->setContent($body);
            $mailing->setFromemail($fromEmail);
            $mailing->setFromname($fromName);
            $mailing->setHeadline($subject);
            $mailing->setTracking($addTracking);

            $currentUser->addMailing($mailing);
            $currentUser->save();
            return true;
        } else {
            throw new \ApplicationException("There is no such user.");
            return false;
        }
    }

    function getUserMailings($userMail, $raw = false) {
        $currentUser = UserQuery::create()->filterByEmail($userMail)->findOne();
        if(!is_null($currentUser)) {
            $userMailings = MailingQuery::create()->filterByUser($currentUser)->find();
            if (!$raw) {
                return $userMailings->toJSON();
            }
            return $userMailings->toArray();
        } else {
            throw new \ApplicationException("There is no such user.");
            return false;
        }
    }

    function getMailing($userMail, $mailingID) {
        $currentUser = UserQuery::create()->filterByEmail($userMail)->findOne();
        if(!is_null($currentUser)) {
            $currentMailing = \DB\MailingQuery::create()->filterById($mailingID)->findOne();
            if(!is_null($currentMailing)) {
                return $currentMailing->toJSON();
            } else {
                throw new \ApplicationException("There is no such mailing.");
                return false;
            }
        } else {
            throw new \ApplicationException("There is no such user.");
            return false;
        }
    }

    function editMailing($userMail, $mailingID, $newName, $newDescription, $newFromEmail, $newFromName, $newSubject, $newBody, $newAddTracking) {
        $currentUser = UserQuery::create()->filterByEmail($userMail)->findOne();
        if(!is_null($currentUser)) {
            $currentMailing = \DB\MailingQuery::create()->filterById($mailingID)->findOne();
            if(!is_null($currentMailing)) {
                $currentMailing->setName($newName);
                $currentMailing->setDescription($newDescription);
                $currentMailing->setFromemail($newFromEmail);
                $currentMailing->setFromname($newFromName);
                $currentMailing->setHeadline($newSubject);
                $currentMailing->setContent($newBody);
                $currentMailing->setTracking($newAddTracking);
                $currentMailing->save();
                return true;
            } else {
                throw new \ApplicationException("There is no such mailing.");
                return false;
            }
        } else {
            throw new \ApplicationException("There is no such user.");
            return false;
        }
    }

    function deleteMailing($userMail, $mailingID) {
        $currentUser = UserQuery::create()->filterByEmail($userMail)->findOne();
        if(!is_null($currentUser)) {
            $currentMailing = MailingQuery::create()->filterById($mailingID)->filterByUser($currentUser)->findOne();
            if(!is_null($currentMailing)) {
                $victimSubscriptions = VictimMailingsQuery::create()->filterByMailing($currentMailing)->find();
                if($victimSubscriptions->count() > 0) {
                    foreach ($victimSubscriptions as $victimSubscription) {
                        $victimSubscription->delete();
                    }
                }
                $userSubscriptions = UserMailingsQuery::create()->filterByMailing($currentMailing)->find();
                if($userSubscriptions->count() > 0) {
                    foreach ($userSubscriptions as $userSubscription) {
                        $userSubscription->delete();
                    }
                }
                $groupSubscriptions = GroupMailingsQuery::create()->filterByMailing($currentMailing)->find();
                if($groupSubscriptions->count() > 0) {
                    foreach ($groupSubscriptions as $groupSubscription) {
                        $groupSubscription->delete();
                    }
                }
                $currentMailing->delete();
                return true;
            } else {
                throw new \ApplicationException("There is no such mailing.");
                return false;
            }
        } else {
            throw new \ApplicationException("There is no such user.");
            return false;
        }
    }

}
