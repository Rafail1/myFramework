<?php

namespace Models\Form;

class AddTaskForm extends \Models\Form\Form {

    public function __construct($id = null) {
        $this->rulesArr = [
            "user_name" => ["required" => true],
            "email" => ["type" => "email"],
            "description" => ["required" => true]
        ];
        $this->fields = ["inputs" => [
                ["name" => "user_name", "type" => "text"],
                ["name" => "email", "type" => "email"],
                ["name" => "description", "type" => "text"],
                ["name" => "picture", "type" => "file", "extensions" => "jpg,jpeg,gif,png"],
            ],
            "action" => ""
        ];
        if ($id) {
            $this->fields["inputs"][] = ["name" => "id", "type" => "hidden", "value" => $id];
        }
    }

}
