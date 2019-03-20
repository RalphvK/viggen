<?php

    require __DIR__.'/config.php';

    $_ENV['ENVIRONMENT'] = 'DEBUG';
    $_ENV['cli'] = true;

    session_start();

    // bootstrap
    echo "\n\033[102m DOCUMENT START \033[0m\n\n";
    echo "\033[32m";
    require COMPOSER_CFG::BACK_END_PATH.'app/bootstrap.php';
    echo "\033[0m\n";

    if (isset($argv[1])) {

        function arg_is($arg) {
            global $argv;
            return ($argv[1] == $arg);
        }

        echo "\n\n\033[104m DEBUG START \033[0m\n";
        echo "\033[94m\n";

        // example
        if (arg_is('example')) {
            echo "This is an example debug command.";
        }

    }

    echo "\033[0m\n";