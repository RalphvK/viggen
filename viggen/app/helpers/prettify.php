<?php

    function prettify_json($json) {
        return json_encode(json_decode($json), JSON_PRETTY_PRINT);
    }

?>