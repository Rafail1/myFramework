<?php

define("SALT", "g3G(~ :");
define("DBNAME", "coding");
define("DBUSER", "root");
define("DBPASS", "5033655");
define("DBCHARSET", "utf8");
define("TASKS_ON_PAGE", 3);
define("MAIN_DIR",  "/bj");
define("DOCUMENT_ROOT", filter_input(INPUT_SERVER, "DOCUMENT_ROOT"));
define("PUBLIC_DIR",  MAIN_DIR."/assets");
define("ABS_MAIN_DIR",  DOCUMENT_ROOT . MAIN_DIR);
define("UPLOAD_DIR",  ABS_MAIN_DIR."/upload");
define("CACHE_DIR",  ABS_MAIN_DIR."/cache");

function Redirect($to){
    header('Location:'.$to);
}

function addScript($src) {
    global $scripts;
    $scripts[] = $src;    
}
$scripts = [];


$controllers = [
    'auth' => [\Controllers\Auth\AuthController::class],
    'task' => [\Controllers\Task\TaskController::class],
    'index' => [\Controllers\Index\IndexController::class]
];

//require_once $_SERVER['DOCUMENT_ROOT'] . '/libs/PHPExcel/PHPExcel.php';
require_once 'autoload.php';

/**
 *
 * @global Models\User\Entity\User $GLOBALS['USER']
 * @name $USER
 */
$USER = Models\User\Entity\User::getInstance();
\Models\User\Model::getInstance()->authByCookie();