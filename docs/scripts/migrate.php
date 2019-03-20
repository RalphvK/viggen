<?php

    require __DIR__.'/config.php';

    $back_end_path = COMPOSER_CFG::BACK_END_PATH;
    $migrations_path = COMPOSER_CFG::MIGRATIONS_PATH;

    // require composer packages
    require $back_end_path.'vendor/autoload.php';

    // load ENV
    $dotenv = new Dotenv\Dotenv($back_end_path);
    $dotenv->load();

    // helpers
    require $back_end_path.'app/helpers/path.php';
    require path::app('/helpers/database.php');

    // create table
    try {
        DB::createTable('migrations', [
            'id' => 'INT AUTO_INCREMENT NOT NULL',
            'name' => 'varchar(200)',
            'executed' => 'DATETIME DEFAULT CURRENT_TIMESTAMP'
        ]);
    } catch(PDOException $e) {
        echo $e->getMessage();
        die();
    }

    function migrationExists($name) {
        // get customer from database
        $stmt = DB::conn()->prepare("SELECT * FROM migrations WHERE `name` = ?");
        $stmt->execute([$name]);
        $result = $stmt->fetch();
        // if customer is found
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    // iterate through migrations
    $dir = new DirectoryIterator($migrations_path);
    foreach ($dir as $fileinfo) {
        if (!$fileinfo->isDot()) {
            // get migration name
            $migration_name = substr($fileinfo->getFilename(), 0, -4);
            
            // check if migration has already been run
            if (!migrationExists($migration_name)) {
                // run migration
                include $migrations_path.$fileinfo->getFilename();
                if ($migration_name() !== false) {
                    // register migration
                    $sql = 'INSERT INTO `migrations` (`name`) VALUES ("'.$migration_name.'");';
                    DB::conn()->exec($sql);
                    // $migration_name();
                    echo "\033[92mExecuted migration: ".$migration_name."\033[0m\n";
                } else {
                    echo "\033[91mError executing migration: ".$migration_name."\033[0m\n";
                }

            } else {
                echo "\033[94mSkipping migration: ".$migration_name."\033[0m\n";
            }

        }
    }

?>