<?php

    $router = new \Klein\Klein();

    /*
    home
    */
    $router->respond('GET', '/', function ($request, $response, $service) {
        $service->render(path::app('view/views/index.php'));
    });

    /*
    protected route example
    */
    $router->respond('GET', '/protected', function ($request) {
        require path::bootstrap('admin');
        if (auth::loggedIn()) {
            redirect::relative('/admin');
        } else {
            redirect::relative('/login');
        }
    });

    /*
    component routes
    */
    routeLoader::component('auth');
    // load remaining components
    routeLoader::allComponents();

    $router->dispatch();