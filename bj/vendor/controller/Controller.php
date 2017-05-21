<?php

namespace Vendor\Controller;

class Controller {

    protected $post;

    public function __construct() {
        $this->post = filter_input_array(INPUT_POST);
    }

    public function render($view) {
        $class_info = new \ReflectionClass($this);
        include dirname($class_info->getFileName()) . "/views/{$view}.php";
    }

    public function getMessage($name) {
        return 'sss';
    }

}
