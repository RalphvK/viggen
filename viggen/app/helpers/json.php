<?php

    function json_file($data, $status = "success", $meta = null) {
        header('Content-Type: application/json');
        $output['status'] = $status; // status
        if ($meta) {
            $output = $output + $meta; // meta
        }
        $output['data'] = $data; // data
        return json_encode($output);
    }

    function json_file_expedite(...$args) {
        $json = json_file(...$args);
        ob_start();
        echo $json; // send the response
        header('Connection: close');
        header('Content-Length: '.ob_get_length());
        ob_end_flush();
        ob_flush();
        flush();
        return $json;
    }