<?php

    class layoutArea {

        static protected $areas;

        static public function init()
        {
            self::$areas = [];
        }

        /**
         * append content
         *
         * @param string $area - name of area
         * @param string $content - script code
         * @return void
         */
        static public function append($area, $content)
        {
            if (!isset(self::$areas[$area]) || !is_array(self::$areas[$area])) {
                self::$areas[$area] = [];
            }
            self::$areas[$area][] = $content;
        }

        static public function appendFile($area, $path, $tag = null)
        {
            $content = file_get_contents($path);
            if ($tag) {
                $tag = [
                    "open" => '<'.$tag.'>',
                    "close" => '</'.$tag.'>'
                ];
                $content = $tag['open'] . "\n" . $content . "\n" . $tag['close'];
            }
            return self::append($area, $content);
        }

        /**
         * render area
         * can be safely used even if it is unknown whether any code is defined
         *
         * @param string $name - which area to load
         * @param string $open_tag - prepended to each script
         * @param string $closing_tag - appended to each script
         * @return string output if items are found
         * @return boolean if no scripts could be found
         */
        static public function render($name, $open_tag = '', $closing_tag = '')
        {
            if (is_array(self::$areas) && isset(self::$areas[$name]) && is_array(self::$areas[$name])) {
                $output = "\n";
                foreach (self::getArea($name) as $key => $content) {
                    $output .= $open_tag . "\n" . $content . "\n" . $closing_tag . "\n";
                }
                return $output;
            } else {
                return false;
            }
        }

        static public function getArea($name)
        {
            return self::$areas[$name];
        }

    }

    layoutArea::init();