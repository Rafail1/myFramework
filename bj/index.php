<?php
set_time_limit(0);
ini_set('error_reporting', E_ERROR);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

header('Content-Type: text/html; charset=utf8');
require_once 'init.php';

$routeStr = filter_input(INPUT_SERVER, "REQUEST_URI");
$routeStr = str_replace("?" . $_SERVER['QUERY_STRING'], "", $routeStr);
$routeStr = str_replace(MAIN_DIR, "", $routeStr);

if($routeStr == "/") {
    $routeStr = "/index/index";
}

$routes = explode('/', $routeStr);
$routes = array_filter($routes);
$routeArr = [];
foreach ($routes as $str) {
    $routeArr[] = $str;
}
ob_start();

if ($controllers[$routeArr[0]]) {
   
    if ($controllers[$routeArr[0]][1]) {
        if (!$USER->isAuthorized()) {
            Redirect(MAIN_DIR . '/auth');
        }
    }
   
    $controller = new $controllers[$routeArr[0]][0]();

    if ($routeArr[1]) {
        $action = $routeArr[1] . "Action";
    } else {
        $action = 'indexAction';
    }
    
    if (method_exists($controller, $action)) {
        if (count($routeArr) > 2) {
            $controller->$action($routeArr[2]);
        } else {
            $controller->$action();
        }
    } else {
        include '404.php';
    }
} else {
    
    include '404.php';
}

ob_end_flush();
