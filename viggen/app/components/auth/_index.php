<?php

    // open component
    path::openComponent('auth');

    // include files
    include path::this('crypto.php');
    include path::this('auth.php');

    // close component
    path::closeComponent();