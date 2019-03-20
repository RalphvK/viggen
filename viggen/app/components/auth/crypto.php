<?php

    class crypto {

        static function hash($password)
        {
            return password_hash($password, PASSWORD_DEFAULT); // does 2^10=1024 rounds of BCRYPT, generates own salt
            // returns hash string
        }

        static function checkPassword($input_password, $stored_password)
        {
            return password_verify($input_password, $stored_password);
            // returns boolean
        }

        static function generateSalt()
        {
            return bin2hex(random_bytes(32));
            // returns salt string
        }

        static function generateToken()
        {
            return bin2hex(random_bytes(16));
            // returns token string
        }
    
    }