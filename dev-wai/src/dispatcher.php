<?php

const REDIRECT_PREFIX = 'redirect:';

function dispatch($routing, $action_url) {
    if(isset($routing[$action_url])) {
        $controller_name = $routing[$action_url];
        $model = [];
        $view_name = $controller_name($model);
        build_response($view_name, $model);
    } 
    else {
        handle_default_route();
    }
}

function build_response($view, $model) {
    if (strpos($view, REDIRECT_PREFIX) === 0) {
        $url = substr($view, strlen(REDIRECT_PREFIX));
        header("Location: " . $url);
        exit;

    } 
    else {
        render($view, $model);
    }
}

function render($view_name, $model) {
    global $routing;
    extract($model);
    include 'views/' . $view_name . '.php';
}

function handle_default_route() {
    http_response_code(404);
    echo 'Strona nie znaleziona';
    exit;
}