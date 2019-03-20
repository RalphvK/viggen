<?php

    /**
     * PHP alternative for .env files
     * allows you to set configurations as arrays and other data types
     */

     /**
      * loadEnvPHP
      * loads php file and merges returned array with $_ENV
      *
      * @param string $path - path relative to app folder
      * @return void
      */
    function loadEnvPHP($path) {
        $envPHP = (include __DIR__.'/../'.$path);
        $_ENV = array_merge($_ENV, $envPHP);
    }

    loadEnvPHP('../.env.php');