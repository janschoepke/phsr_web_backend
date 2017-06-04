<?php

/**
 * Created by PhpStorm.
 * User: janschopke
 * Date: 01.06.17
 * Time: 15:34
 */
namespace src\services;

use \DB\User;
use \DB\UserQuery;

class UserService {

    function register($firstname, $lastname, $email, $password) {
        if($this->userExists($email)) {
            throw new \ApplicationException("There is an existing user with this email address.");
            return false;
        }

        $passwordData = $this->saltPassword($password);

        try {
            $user = new User();
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setEmail($email);
            $user->setSalt($passwordData['salt']);
            $user->setPwHash($passwordData['hashedPassword']);
            $user->save();
        } catch (PropelException $pe) {
            throw new \ApplicationException("Error saving the user to the database.");
            return false;
        }
        return true;
    }

    function login($email, $password) {
        $currentUser = UserQuery::create()->filterByEmail($email)->findOne();
        if(!is_null($currentUser)) {
            $enteredPassword = $this->saltPassword($password, $currentUser->getSalt());
            if($enteredPassword['hashedPassword'] === $currentUser->getPwhash()) {
                $tokenService = new TokenService();
                $jwt = $tokenService->generateJWT(array($currentUser->getEmail()));
                return $jwt;
            }
            throw new \ApplicationException("The email/password combination does not match.");
            return false;
        }
        throw new \ApplicationException("The email address you entered is not known.");
        return false;
    }

    function userExists($email) {
        // Null, when user does not exist.
        $userExists = is_null(UserQuery::create()->filterByEmail($email)->findOne());
        return !$userExists;
    }

    function saltPassword($password, $salt = NULL) {
        if($salt === NULL) {
            $salt = $this->getRandomSalt();
        }

        $options = [
            'cost' => 12,
            'salt' => $salt
        ];

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT, $options);

        return ['salt' => $salt, 'hashedPassword' => $hashedPassword];
    }

    function getRandomSalt($length = 22) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
