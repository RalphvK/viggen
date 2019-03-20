<?php

    class CORS {

        static public function parse($string) {
            $expression = '/,\s*/';
            return preg_split($expression, $string);
        }

        static public function setHeaders($whitelist) {
            if (is_string($whitelist)) {
                $whitelist = self::parse($whitelist);
            }
            if (isset($_SERVER["HTTP_ORIGIN"])) {
                if (in_array($_SERVER["HTTP_ORIGIN"], $whitelist)) {
                    header('Access-Control-Allow-Origin: '.$_SERVER["HTTP_ORIGIN"]);
                    header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
                    header("Access-Control-Allow-Headers: X-Requested-With");
                    header("Access-Control-Allow-Credentials: true");
                }
            }
        }

    }

?>