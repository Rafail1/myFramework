<?php

namespace Controllers\Auth;

class AuthController extends \Vendor\Controller\Controller {
    
    public function indexAction() {
        
        if (!empty($this->post)) {
            $this->loginAction();
        } else {
            $form = new \Models\Form\AuthForm();
            echo json_encode($form->getFields());
        }
    }

    public function loginAction() {
        global $USER;
        $form = new \Models\Form\AuthForm();

        if ($USER->isAuthorized()) {
            Redirect(MAIN_DIR);
        } else {
            if ($form->validate($this->post)) {
                echo json_encode($form->getFields());
            } else {
                \Models\User\Model::getInstance()->authUser(filter_input(INPUT_POST, 'login'), filter_input(INPUT_POST, 'password'));
                if ($USER->isAuthorized()) {
                    Redirect(MAIN_DIR);
                } else {
                    echo json_encode($form->getFields());
                }
            }
        }
    }

    public function registerAction() {
        $form = new \Models\Form\RegisterForm();
        if (!$form->validate($this->post)) {
            echo json_encode($form->getFields());
        } else {
            if (\Models\User\Model::getInstance()->createUser($this->post)) {
                \Redirect(MAIN_DIR);
            } else {
                echo json_encode($form->getFields());
            }
        }
    }

}
