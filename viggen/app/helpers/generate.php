<?php

    class generate {

        /*
        Generate random 32 chr form id
        */
        static public function form_id() {
            return bin2hex(random_bytes(16));
        }

    }