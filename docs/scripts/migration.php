<?php

    require __DIR__.'/config.php';

    // config
    $migration = [
        'path' => COMPOSER_CFG::MIGRATIONS_PATH,
        'prefix' => 'migration_'
    ];

    // get date
    $date = new DateTime();
    $migration_name = $migration['prefix'].$date->getTimestamp();

    // file content
    $content = file_get_contents(__DIR__.'/migrationTemplate.php');
    $content = str_replace("migration_name", $migration_name, $content);

    // create file
    $fp = fopen($migration['path'] . $migration_name . ".php", "wb");
    fwrite($fp,$content);
    fclose($fp);

    echo 'Created migration template: '.$migration['path'] . $migration_name . ".php";
?>