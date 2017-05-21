<?php

function _autoload($class) {
    
    if(class_exists($class)) {
        return;
    }
    if(file_exists($class)) {
        require_once $class;
        return;
    }
    $farr = explode("\\", $class);

    $findex = count($farr) - 1;
    for ($i = 0; $i < $findex; $i++) {
        $farr[$i] = strtolower($farr[$i]);
    }
    $fname = implode(DIRECTORY_SEPARATOR, $farr);
    $fname = DOCUMENT_ROOT.MAIN_DIR .DIRECTORY_SEPARATOR .$fname;
    require_once $fname. '.php';
}

spl_autoload_register('_autoload');
