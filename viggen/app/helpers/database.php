<?php

    class DB {

        static public $connection;

        // creating PDO object
        static public function connect() {
            $db_config = [
                'host' => $_ENV['DB_HOST'],
                'database' => $_ENV['DB_NAME'],
                'user' => $_ENV['DB_USER'],
                'password'=> $_ENV['DB_PASSWORD'],
                'charset' => 'utf8'
            ];
    
            $PDO_opt = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            $PDO_dsn = "mysql:host=".$db_config['host'].";dbname=".$db_config['database'].";charset=".$db_config['charset'];
            self::$connection = new PDO($PDO_dsn, $db_config['user'], $db_config['password'], $PDO_opt);

            // hook up ORM
            ORM::set_db(self::$connection);
        }

        // get connection method
        static public function conn() {
            return self::$connection;
        }

        // create table
        /*
        Note: this function is designed to be a temporary addition until a proper equivalent for the DB class is written
        */
        function createTable($table,$fields)
        {
            $sql = "CREATE TABLE IF NOT EXISTS `$table` (";
            $pk  = '';

            foreach($fields as $field => $type) {
                $sql.= "`$field` $type,";
                if (preg_match('/AUTO_INCREMENT/i', $type))
                {
                    $pk = $field;
                }
            }

            $sql = rtrim($sql,',') . ', PRIMARY KEY (`'.$pk.'`)';
            $sql .= ") CHARACTER SET utf8 COLLATE utf8_general_ci;";

            return self::conn()->exec($sql);
        }

    }

    // initialising connection
    DB::connect();