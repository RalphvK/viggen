<?php

    require __DIR__.'/config.php';

    $back_end_path = COMPOSER_CFG::BACK_END_PATH;

    // require env.php
    require $back_end_path.'app/helpers/path.php';
    require $back_end_path.'app/helpers/env.php';

    foreach ($_ENV as $key => $value) {
        echo "\033[94m\"".$key."\"\033[0m => \033[92m\"".$value."\"\033[0m\n";
    }

?>