<?php

/**
 * Created by PhpStorm.
 * User: janschopke
 * Date: 01.06.17
 * Time: 16:59
 */
class ApplicationException extends Exception {
    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
