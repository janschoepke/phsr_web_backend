<?php
/**
 * Created by PhpStorm.
 * User: janschopke
 * Date: 01.06.17
 * Time: 23:37
 */

namespace src\services;

use \Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;


class TokenService {

    private $key = "example_key";

    function generateJWT($payload) {
        $jwt = JWT::encode($payload, $this->key);
        return $jwt;
    }

    function decodeJWT($jwt) {
        try {
            $decoded = JWT::decode($jwt, $this->key, array('HS256'));
        } catch (SignatureInvalidException $e) {
            return false;
        }
        return $decoded;
    }


}

