<?php
namespace Controllers\Admin;

class AdminController {


    public function indexAction() {
        $model = \Models\Task\Model::getInstance();
        $tasks = $model->getOnePage(filter_input(INPUT_GET, "page"), TASKS_ON_PAGE);
    }

   
}
