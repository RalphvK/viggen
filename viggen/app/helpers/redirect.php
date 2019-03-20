<?php

    class redirect {

        static function relative($url,$statuscode=302)
        {
            header("Location: ".self::getSiteURL().$url, true, $statuscode);
            exit;
        }

        static function external($url,$statuscode=302)
        {
            header("Location: ".$url, true, $statuscode);
            exit;
        }

        static function abort($code = 403)
        {
            global $klein;
            $klein->abort($code);
        }

        static function getSiteURL()
        {
            if (!$_ENV['BASE_URL_ENFORCE']) {
                $http_host = $_SERVER['HTTP_HOST'];
                if (isset($http_host)) {
                    return $_ENV['PROTOCOL'].$http_host;
                } else {
                    return $_ENV['BASE_URL_FALLBACK'];
                }
            } else {
                return $_ENV['PROTOCOL'].$_ENV['BASE_URL_ENFORCE'];
            }
        }

    }