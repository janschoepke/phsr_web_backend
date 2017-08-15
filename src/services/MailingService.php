<?php
/**
 * Created by PhpStorm.
 * User: janschopke
 * Date: 15.06.17
 * Time: 13:46
 */

namespace src\services;


use DB\Base\GroupQuery;
use DB\VictimMailings;
use DB\MailingQuery;
use DB\VictimMailingsQuery;
use DB\GroupMailingsQuery;
use DB\Mailing;
use DB\UserMailingsQuery;
use DB\UserQuery;
use DB\VictimQuery;
use DB\WebVisitQuery;
use PHPMailer\PHPMailer\PHPMailer;
use Propel\Runtime\Propel;
use PDO;

class MailingService
{

    function sendSMTPMail($fromEmail, $fromName, $toEmail, $toName, $subject, $body, $smtpHost, $smtpUser, $smtpPassword, $smtpSecure, $smtpPort) {
        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->Host = $smtpHost;
        $mail->SMTPAuth = true;
        $mail->Username = $smtpUser;
        $mail->Password = $smtpPassword;
        $mail->SMTPSecure = $smtpSecure;
        $mail->Port = $smtpPort;

        $mail->setFrom($fromEmail, $fromName);
        $mail->addAddress($toEmail, $toName);

        $mail->isHTML(true);

        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->Encoding = 'quoted-printable';
        $mail->CharSet = 'utf-8';

        if(!$mail->send()) {
            throw new \ApplicationException('Mail could not be sent: ' . $mail->ErrorInfo);
            return false;
        }
        return true;
    }

    function sendMail($fromEmail, $fromName, $toEmail, $toName, $subject, $body) {
        $mail = new PHPMailer;

        $mail->setFrom($fromEmail, $fromName);
        $mail->addAddress($toEmail, $toName);

        $mail->isHTML(true);

        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->Encoding = 'quoted-printable';
        $mail->CharSet = 'UTF-8';

        if(!$mail->send()) {
            throw new \ApplicationException('Mail could not be sent: ' . $mail->ErrorInfo);
            return false;
        }
        return true;

    }

    function replaceFirstnameVariable($text, $firstname) {
        return str_replace("(phsr:firstname)", $firstname, $text);
    }

    function replaceLastnameVariable($text, $lastname) {
        return str_replace("(phsr:lastname)", $lastname, $text);
    }

    function replaceEmailVariable($text, $email) {
        return str_replace("(phsr:email)", $email, $text);
    }

    function replaceSalutationVariable($text, $gender) {
        if (strpos($text, '(phsr:salutation') !== false) {
            preg_match_all('/\((phsr:salutation[A-Za-z0-9 :|]+?)\)/', $text, $matches);
            foreach($matches[0] as $match) {
                $temp = str_replace(")", "", $match);
                $options = explode('|', $temp);
                if($gender) {
                    $text = str_replace($match, $options[1], $text);
                } else {
                    $text = str_replace($match, $options[2], $text);
                }
            }
        }
        return $text;
    }

    function replaceLinkVariable($text, $userid, $groupid, $victimUuid) {
        if (strpos($text, '(phsr:link') !== false) {

            preg_match_all('/\((phsr:link[A-Za-z0-9 :|\/.]+?)\)/', $text, $matches);
            foreach($matches[0] as $match) {
                $temp = str_replace(")", "", $match);
                $options = explode('|', $temp);
                $userParam = '?user='. $userid . '&group=' . $groupid . '&uuid=' . $victimUuid;
                $text = str_replace($match, '<a href="' . $options[2] . $userParam . '">' . $options[1] . "</a>", $text);
            }
        }
        return $text;
    }

    function replaceVariables($text, $firstname, $lastname, $email, $gender, $userId, $groupId, $victimUuid) {
        $tempText = $this->replaceFirstnameVariable($text, $firstname);
        $tempText = $this->replaceLastnameVariable($tempText, $lastname);
        $tempText = $this->replaceEmailVariable($tempText, $email);
        $tempText = $this->replaceSalutationVariable($tempText, $gender);
        $tempText = $this->replaceLinkVariable($tempText, $userId, $groupId, $victimUuid);
        return $tempText;
    }

    function insertTrackingPixel($text, $userId, $mailingId, $victimUuid) {
        $imageLink = '<img src="http://' . $_SERVER['HTTP_HOST'] . '/resources/image.gif?m=' . $mailingId . "&user=" .$userId . "&uuid=" . $victimUuid . '" />';

        if(strpos($text, '</body>') !== false) {
            //closing body-tag found in email source.
            $text = str_replace('</body>', $imageLink . '</body>', $text);
        } else {
            //no closing body tag in email source.
            $text = $text . $imageLink;
        }
        return $text;
    }

    function sendMailToGroup($userMail, $groupId, $fromEmail, $fromName, $subject, $body) {
        $victimService = new VictimService();
        $victims = $victimService->getGroupVictims($userMail, $groupId, true);

        foreach ($victims as $victim) {
            var_dump($victim);
            $this->sendMail($fromEmail, $fromName, $victim['Email'], $victim['Firstname'] . ' ' . $victim['Lastname'], $subject, $body);
        }

    }

    function sendMailingToGroup($userMail, $groupId, $mailingId) {
        $currentUser = UserQuery::create()->filterByEmail($userMail)->findOne();
        if(!is_null($currentUser)) {
            $mailing = $this->getMailing($userMail, $mailingId, true);
            if($mailing) {
                $victimService = new VictimService();
                $victims = $victimService->getGroupVictims($userMail, $groupId, true);

                $currentMailing = MailingQuery::create()->filterById($mailingId)->findOne();

                date_default_timezone_set("Europe/Berlin");

                if($mailing['Issmtp']) {
                    foreach($victims as $victim) {
                        $victimUuid = uniqid();

                        $specificHeadline = $this->replaceVariables($mailing['Headline'], $victim['Firstname'], $victim['Lastname'], $victim['Email'], $victim['Gender'], $victim['Id'], $groupId, $victimUuid);
                        $specificContent = $this->replaceVariables($mailing['Content'], $victim['Firstname'], $victim['Lastname'], $victim['Email'], $victim['Gender'], $victim['Id'], $groupId, $victimUuid);
                        $specificContentWTrackingPx = $this->insertTrackingPixel($specificContent, $victim['Id'], $mailing['Id'], $victimUuid);

                        $currentVictimMailing = new VictimMailings();
                        $currentVictimMailing->setVictimId($victim['Id']);
                        $currentVictimMailing->setMailing($currentMailing);
                        $currentVictimMailing->setTimestamp(time());
                        $currentVictimMailing->setOpened(false);
                        $currentVictimMailing->setClicked(false);
                        $currentVictimMailing->setConversioned(false);
                        $currentVictimMailing->setGroupId($groupId);
                        $currentVictimMailing->setUniqueId($victimUuid);
                        $currentVictimMailing->save();

                        $this->sendSMTPMail($mailing['Fromemail'], $mailing['Fromname'], $victim['Email'], $victim['Firstname'] . ' ' . $victim['Lastname'], $specificHeadline, $specificContentWTrackingPx, $mailing['Smtphost'], $mailing['Smtpuser'], $mailing['Smtppassword'], $mailing['Smtpsecure'], $mailing['Smtpport']);
                    }
                } else {
                    foreach($victims as $victim) {
                        $victimUuid = uniqid();

                        $specificHeadline = $this->replaceVariables($mailing['Headline'], $victim['Firstname'], $victim['Lastname'], $victim['Email'], $victim['Gender'], $victim['Id'], $groupId, $victimUuid);
                        $specificContent = $this->replaceVariables($mailing['Content'], $victim['Firstname'], $victim['Lastname'], $victim['Email'], $victim['Gender'], $victim['Id'], $groupId, $victimUuid);
                        $specificContentWTrackingPx = $this->insertTrackingPixel($specificContent, $victim['Id'], $mailing['Id'], $victimUuid);

                        $currentVictimMailing = new VictimMailings();
                        $currentVictimMailing->setVictimId($victim['Id']);
                        $currentVictimMailing->setMailing($currentMailing);
                        $currentVictimMailing->setTimestamp(time());
                        $currentVictimMailing->setOpened(false);
                        $currentVictimMailing->setClicked(false);
                        $currentVictimMailing->setConversioned(false);
                        $currentVictimMailing->setGroupId($groupId);
                        $currentVictimMailing->setUniqueId($victimUuid);
                        $currentVictimMailing->save();

                        $this->sendMail($mailing['Fromemail'], $mailing['Fromname'], $victim['Email'], $victim['Firstname'] . ' ' . $victim['Lastname'], $specificHeadline, $specificContentWTrackingPx);
                    }
                }

                $currentGroup = GroupQuery::create()->filterById($groupId)->findOne();
                $currentMailing->addGroup($currentGroup);
                $currentMailing->save();

            }
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
            $mailing->setIssmtp(false);

            $currentUser->addMailing($mailing);
            $currentUser->save();

            return $mailing->getId();
        } else {
            throw new \ApplicationException("There is no such user.");
            return false;
        }
    }

    function addSMTPMailing($userMail, $name, $description, $fromEmail, $fromName, $subject, $body, $addTracking, $smtpHost, $smtpUser, $smtpPassword, $smtpSecure, $smtpPort) {
        $currentUser = UserQuery::create()->filterByEmail($userMail)->findOne();
        if(!is_null($currentUser)) {
            $tokenService = new TokenService();

            $mailing = new Mailing();
            $mailing->setName($name);
            $mailing->setDescription($description);
            $mailing->setContent($body);
            $mailing->setFromemail($fromEmail);
            $mailing->setFromname($fromName);
            $mailing->setHeadline($subject);
            $mailing->setTracking($addTracking);
            $mailing->setSmtphost($smtpHost);
            $mailing->setIssmtp(true);
            $mailing->setSmtpuser($smtpUser);
            $mailing->setSmtppassword($tokenService->encryptPassword($smtpPassword));
            $mailing->setSmtpsecure($smtpSecure);
            $mailing->setSmtpport($smtpPort);

            $currentUser->addMailing($mailing);
            $currentUser->save();
            return $mailing->getId();
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

    function getMailing($userMail, $mailingID, $raw = false) {
        $currentUser = UserQuery::create()->filterByEmail($userMail)->findOne();
        if(!is_null($currentUser)) {
            $currentMailing = \DB\MailingQuery::create()->filterById($mailingID)->findOne();
            if(!is_null($currentMailing)) {
                $tokenService = new TokenService();

                $decryptedPassword = $tokenService->decryptPassword($currentMailing->getSmtppassword());
                $mailingData = $currentMailing->toArray();

                $mailingData['Smtppassword'] = $decryptedPassword;

                if(!$raw) {
                    return json_encode($mailingData);
                }
                return $mailingData;
            } else {
                throw new \ApplicationException("There is no such mailing.");
                return false;
            }
        } else {
            throw new \ApplicationException("There is no such user.");
            return false;
        }
    }

    function editMailing($userMail, $mailingID, $newName, $newDescription, $newFromEmail, $newFromName, $newSubject, $newBody, $newAddTracking, $isSmtp, $smtpHost, $smtpUser, $smtpPassword, $smtpSecure, $smtpPort) {
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

                $currentMailing->setIssmtp($isSmtp);
                if($isSmtp) {
                    $tokenService = new TokenService();
                    $currentMailing->setSmtphost($smtpHost);
                    $currentMailing->setSmtpuser($smtpUser);
                    $currentMailing->setSmtppassword($tokenService->encryptPassword($smtpPassword));
                    $currentMailing->setSmtpsecure($smtpSecure);
                    $currentMailing->setSmtpport($smtpPort);
                }

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

    function getSentMailingIdsByUser($userMail) {
        $currentUser = UserQuery::create()->filterByEmail($userMail)->findOne();
        if(!is_null($currentUser)) {
            $mailings = MailingQuery::create()->filterByUser($currentUser)->find()->toArray();

            $tempMailing = [];

            foreach($mailings as $mailing) {
                $tempMailing = GroupMailingsQuery::create()->filterByMailingId($mailing['Id'])->find()->toArray();

            }
            return $tempMailing;
        } else {
            throw new \ApplicationException("There is no such user.");
            return false;
        }
    }

    function execCustomSQLStatement($sql, $map) {
        $con = Propel::getConnection();

        $stmt = $con->prepare($sql);
        $stmt->execute($map);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    function getAllSentMailings($userMail) {
        $currentUser = UserQuery::create()->filterByEmail($userMail)->findOne();
        if(!is_null($currentUser)) {
            $sentMailings = $this->getSentMailingIdsByUser($userMail);

            $sentMailingsData = [];

            for($i = 0; $i < sizeof($sentMailings); $i++) {
                $tempResult = [];
                $tempStatData = VictimMailingsQuery::create()->filterByMailingId($sentMailings[$i]['MailingId'])->filterByGroupId($sentMailings[$i]['GroupId'])->joinWithVictim()->find()->toArray();
                $tempMailingData = MailingQuery::create()->filterById($sentMailings[$i]['MailingId'])->findOne()->toArray();
                $tempGroupData = GroupQuery::create()->filterById($sentMailings[$i]['GroupId'])->findOne()->toArray();
                $tempBrowserData = WebVisitQuery::create()->withColumn('COUNT(browser)', 'CountBrowser')->select(array('browser', 'CountBrowser'))->filterByMailingId($sentMailings[$i]['MailingId'])->filterByGroupId($sentMailings[$i]['GroupId'])->groupByBrowser()->orderByCountBrowser()->find()->toArray();
                $tempOsData = WebVisitQuery::create()->withColumn('COUNT(os)', 'CountOs')->select(array('os', 'CountOs'))->groupByOs()->orderByCountOs()->filterByMailingId($sentMailings[$i]['MailingId'])->filterByGroupId($sentMailings[$i]['GroupId'])->find()->toArray();

                $webVisitSQL = "SELECT AVG(COUNTER) AS avgVisits, SUM(COUNTER) AS totalVisits, COUNT(victim_id) AS totalVisitors FROM (SELECT COUNT(unique_id) AS COUNTER, victim_id FROM `WebVisits` WHERE mailing_id = :mailingid AND group_id = :groupid GROUP BY unique_id) a";
                $webVisitData = $this->execCustomSQLStatement($webVisitSQL, array(':mailingid' => $sentMailings[$i]['MailingId'], ':groupid' => $sentMailings[$i]['GroupId']));

                $webConversionSQL = "SELECT AVG(COUNTER) AS avgConversions, SUM(COUNTER) AS totalConversions, COUNT(victim_id) AS totalConversioners FROM (SELECT COUNT(unique_id) AS COUNTER, victim_id FROM `WebConversions` WHERE mailing_id = :mailingid AND group_id = :groupid GROUP BY unique_id) a";
                $webConversionData = $this->execCustomSQLStatement($webConversionSQL, array(':mailingid' => $sentMailings[$i]['MailingId'], ':groupid' => $sentMailings[$i]['GroupId']));

                $tempResult['statData'] = $tempStatData;
                $tempResult['mailingsData'] = $tempMailingData;
                $tempResult['groupData'] = $tempGroupData;
                $tempResult['browserData'] = $tempBrowserData;
                $tempResult['osData'] = $tempOsData;
                $tempResult['webVisitData'] = $webVisitData;
                $tempResult['webConversionData'] = $webConversionData;
                array_push($sentMailingsData, $tempResult);
            }

            return $sentMailingsData;

        } else {
            throw new \ApplicationException("There is no such user.");
            return false;
        }
    }

    function getAllStatistics($userMail) {
        $currentUser = UserQuery::create()->filterByEmail($userMail)->findOne();
        if(!is_null($currentUser)) {
            $victimData = VictimQuery::create()->joinWithVictimMailings()->joinWithUserVictims()->filterByUser($currentUser)->find()->toArray();
            return $victimData;

        } else {
            throw new \ApplicationException("There is no such user.");
            return false;
        }
    }

    function getVictimStatistics($userMail) {
        $currentUser = UserQuery::create()->filterByEmail($userMail)->findOne();
        if(!is_null($currentUser)) {
            $victimData = VictimQuery::create()->joinWithUserVictims()->filterByUser($currentUser)->find()->toArray();
            return $victimData;
        } else {
            throw new \ApplicationException("There is no such user.");
            return false;
        }
    }

    function getGroupMailingStatistics($userMail) {
        $currentUser = UserQuery::create()->filterByEmail($userMail)->findOne();
        if(!is_null($currentUser)) {
            $groupCount = GroupQuery::create()->joinWithUserGroups()->filterByUser($currentUser)->count();
            $mailingCount = MailingQuery::create()->joinWithUserMailings()->filterByUser($currentUser)->count();
            return array("groups" => $groupCount, "mailings" => $mailingCount);
        } else {
            throw new \ApplicationException("There is no such user.");
            return false;
        }
    }

}
