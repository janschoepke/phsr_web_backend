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


define('AES_256_CBC', 'aes-256-cbc');


class TokenService {

    private $key = "example_key";
    private $encryptionKey = "DMIHQfu5mAMDFBeVgC/ZV4Kmlu5RZ4IWCmcqVQjV9Tc=";

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

    function encryptPassword($password) {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(AES_256_CBC));
        $encrypted = openssl_encrypt($password, AES_256_CBC, $this->encryptionKey, 0, $iv);
        return $encrypted . ':' . base64_encode($iv);
    }

    function decryptPassword($password) {
        $parts = explode(':', $password);
        return openssl_decrypt($parts[0], AES_256_CBC, $this->encryptionKey, 0, base64_decode($parts[1]));
    }



}

