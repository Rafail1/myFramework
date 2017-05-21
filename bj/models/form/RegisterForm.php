<?php

namespace Models\Form;

class RegisterForm extends \Models\Form\Form {

    private $rulesArr = [
        'login' => ['required' => true, 'min' => 3, 'max' => 12],
        'password' => ['required' => true, 'min' => 6, 'max' => 128],
        'confirm' => ['equivalent' => 'password']
    ];
    private $fields = ["inputs" => [
            ["name" => "login", "type" => "text"],
            ["name" => "password", "type" => "password"],
            ['name' => 'confirm', 'type' => 'password']
        ],
        "action" => MAIN_DIR . "/auth/register"
    ];

    public function __construct() {
        parent::__construct($this->rulesArr, $this->fields);
    }

}
