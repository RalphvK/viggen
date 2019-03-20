<?php

    class path {

        static protected $openComponent;

        /**
         * path to app/ folder
         *
         * @param string $path
         * @return string
         */
        static public function app($path) {
            return __DIR__.'/../'.$path;
        }

        /**
         * get path to secondary bootstrap file (ie. bootstrap-admin.php)
         *
         * @param string $name - name of bootstrapper without "bootstrap-" prefix
         * @return string path to file
         */
        static public function bootstrap($name) {
            return self::app('bootstrap-'.$name.'.php');
        }

        /**
         * get path to router file
         *
         * @param string $name - name of file without .php extension
         * @return string path to file
         */
        static public function router($name) {
            return self::app('routes/'.$name.'.php');
        }

        /**
         * set or get openComponent
         *
         * @param string $name
         * @return string self::$openComponent
         */
        static public function openComponent($name = null) {
            if ($name) {
                self::$openComponent = $name;
            }
            return self::$openComponent;
        }

        // unsets openComponent
        static public function closeComponent() {
            self::$openComponent = null;
        }

        /**
         * path within current component folder
         *
         * @param string $path
         * @return string
         */
        static public function this($path) {
            return self::component(self::$openComponent, $path);
        }

        /**
         * path in given component's folder
         *
         * @param string $component - name of component folder
         * @param string $path - path after components/<name>/, defaults to "_index.php"
         * @return string
         */
        static public function component($component, $path = "_index.php") {
            return __DIR__.'/../components/'.$component.'/'.$path;
        }

        /**
         * get array of with all component names
         *
         * @return array
         */
        static public function getComponents() {
            $names = [];
            foreach (glob(self::app('components/*')) as $key => $path) {
                $names[] = basename($path);
            }
            return $names;
        }

        /**
         * include all files in folder
         *
         * @param string $path
         * @param string $file - expression to match against, defaults to '*.php'
         * @return void
         */
        static public function includeFolder($path, $file = '*.php') {
            foreach (glob($path.'/'.$file) as $filename)
            {
                include $filename;
            }
        }

    }