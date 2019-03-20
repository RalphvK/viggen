<?php
    
    /**
     * Authentication API Routes
     */

     

    /*
    test authentication
    */
    $router->respond('/auth/test', function ($request) {
        require path::bootstrap('admin');
        auth::protect(false);
        return json_file([], 'success');
    });

    /*
    login
    */
    $router->respond('POST', '/auth/login', function ($request) {
        require path::bootstrap('admin');
        require path::component('auth', 'controllers/loginController.php');
        return loginController::login($request);
    });

    /*
    logout
    */
    $router->respond(['POST', 'GET'], '/auth/logout', function ($request) {
        require path::bootstrap('admin');
        require path::component('auth', 'controllers/loginController.php');
        return loginController::logout($request);
    });