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
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

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

    function replaceLinkVariable($text, $userid) {
        if (strpos($text, '(phsr:link') !== false) {

            preg_match_all('/\((phsr:link[A-Za-z0-9 :|\/.]+?)\)/', $text, $matches);
            foreach($matches[0] as $match) {
                $temp = str_replace(")", "", $match);
                $options = explode('|', $temp);
                $userParam = substr($options[2], -1) == '/' ? '?user='. $userid: '/?user='. $userid;
                $text = str_replace($match, '<a href="' . $options[2] . $userParam . '">' . $options[1] . "</a>", $text);
            }
        }
        return $text;
    }

    function replaceVariables($text, $firstname, $lastname, $email, $gender, $userId) {
        $tempText = $this->replaceFirstnameVariable($text, $firstname);
        $tempText = $this->replaceLastnameVariable($tempText, $lastname);
        $tempText = $this->replaceEmailVariable($tempText, $email);
        $tempText = $this->replaceSalutationVariable($tempText, $gender);
        $tempText = $this->replaceLinkVariable($tempText, $userId);
        return $tempText;
    }

    function insertTrackingPixel($text, $userId, $mailingId) {
        $imageLink = '<img src="http://' . $_SERVER['HTTP_HOST'] . '/resources/image.gif?m=' . $mailingId . "&user=" .$userId . '" />';
        //$imageLink = '<img src="https://' . $_SERVER['HTTP_HOST'] . '/resources/image.gif">';
        //$imageLink = '<img src="https://www.raidhuntr.de/phsr-logo.png">';
        //$imageLink = '<img src="https://assets-email1.unidays.world/Campaigns/SystemEmails/7290d70e-0699-490a-a720-1b3d9d2869c6">';

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
                        $specificHeadline = $this->replaceVariables($mailing['Headline'], $victim['Firstname'], $victim['Lastname'], $victim['Email'], $victim['Gender'], $victim['Id']);
                        $specificContent = $this->replaceVariables($mailing['Content'], $victim['Firstname'], $victim['Lastname'], $victim['Email'], $victim['Gender'], $victim['Id']);
                        $specificContentWTrackingPx = $this->insertTrackingPixel($specificContent, $victim['Id'], $mailing['Id']);

                        $currentVictimMailing = new VictimMailings();
                        $currentVictimMailing->setVictimId($victim['Id']);
                        $currentVictimMailing->setMailing($currentMailing);
                        $currentVictimMailing->setTimestamp(time());
                        $currentVictimMailing->setOpened(false);
                        $currentVictimMailing->setClicked(false);
                        $currentVictimMailing->save();

                        $this->sendSMTPMail($mailing['Fromemail'], $mailing['Fromname'], $victim['Email'], $victim['Firstname'] . ' ' . $victim['Lastname'], $specificHeadline, $specificContentWTrackingPx, $mailing['Smtphost'], $mailing['Smtpuser'], $mailing['Smtppassword'], $mailing['Smtpsecure'], $mailing['Smtpport']);
                    }
                } else {
                    foreach($victims as $victim) {
                        $specificHeadline = $this->replaceVariables($mailing['Headline'], $victim['Firstname'], $victim['Lastname'], $victim['Email'], $victim['Gender'], $victim['Id']);
                        $specificContent = $this->replaceVariables($mailing['Content'], $victim['Firstname'], $victim['Lastname'], $victim['Email'], $victim['Gender'], $victim['Id']);
                        $specificContentWTrackingPx = $this->insertTrackingPixel($specificContent, $victim['Id'], $mailing['Id']);

                        $currentVictimMailing = new VictimMailings();
                        $currentVictimMailing->setVictimId($victim['Id']);
                        $currentVictimMailing->setMailing($currentMailing);
                        $currentVictimMailing->setTimestamp(time());
                        $currentVictimMailing->setOpened(false);
                        $currentVictimMailing->setClicked(false);
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

}
