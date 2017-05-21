<?php

namespace Controllers\Task;

class TaskController extends \Vendor\Controller\Controller {

    public function addAction() {
        $form = new \Models\Form\AddTaskForm();
        if (!empty($this->post) && $form->validate($this->post)) {
            $model = \Models\Task\Model::getInstance();
            $picture = $_FILES["picture"];
            if (!empty($picture)) {
                $picturePath = $model->addPicture($picture);
            } else {
                $picturePath = "";
            }
            $this->post["picture"] = $picturePath;
            if ($model->createTask($this->post)) {
                echo json_encode(["error" => 0, "message" => $this->getMessage('TASK_ADDED')]);
            };
        } else {
            echo json_encode();
        }
    }

    public function indexAction($page = 1) {
        $model = \Models\Task\Model::getInstance();
        $tasks = $model->getOnePage($page, TASKS_ON_PAGE);
        echo json_encode($tasks);
    }

    public function editAction($id) {
        $form = new \Models\Form\AddTaskForm();
        if (!empty($this->post)) {
            $model = \Models\Task\Model::getInstance();
            
            if ($form->validateFields($this->post)) {
                $picture = $_FILES["picture"];
                
                $data = $this->post;
                if (is_array($picture) && !empty($picture['tmp_name'])) {
                    $data["picture"] = $model->addPicture($picture);
                } else {
                    unset($data["picture"]);
                }
                $model->editTask($id, $data);
            }
        } else {
            echo json_encode($form->getFields());
        }
    }

    public function removeAction($id) {
        $model = \Models\Task\Model::getInstance();
        if($model->removeTask($id)) {
            echo json_encode(["error"=>0, "removed_id" => $id]);
        } else {
            echo json_encode(["error"=>1, "problem_id" => $id]);
        };
    }

}
