<?php

    class routeLoader {

        static public $loaded;

        static public function registerLoad($name)
        {
            if (!is_array(self::$loaded)) {
                self::$loaded = [];
            }
            self::$loaded[] = $name;
        }

        static public function isLoaded($name)
        {
            if (!is_array(self::$loaded)) {
                return false;
            }
            if (in_array($name, self::$loaded)) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * load _routes.php file from compnent if not already loaded
         * adds component to $loaded array
         *
         * @param string $name - name of component
         * @return void
         */
        static public function component($name)
        {
            global $router;
            if (!self::isLoaded($name)) {
                self::registerLoad($name);
                include path::component($name, '_routes.php');
            }
        }

        /**
         * iterates through components and loads all _routes.php files that have not been loaded yet
         *
         * @return void
         */
        static public function allComponents()
        {
            global $router;
            foreach (path::getComponents() as $key => $name) {
                $path = path::component($name, '_routes.php');
                if (file_exists($path)) {
                    self::component($name);
                }
            }
        }

    }