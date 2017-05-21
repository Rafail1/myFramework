<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author raf
 */

namespace Models\User\Entity;

class User {

    private $group;
    private $id;
    private $login;
    private $password;
    private $hash;
    private static $instance;

    protected function __construct() {
        
    }
    /**
     * @return User
    */
    static function getInstance(){
        if(self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    function setUser($id, $login, $password) {
        $this->setGroup(1);
        $this->setId($id);
        $this->setLogin($login);
        $this->setPassword($password);
        $this->generateHash();
    }

    public function generateHash() {
        $this->hash = md5(SALT . $this->login . $this->password);
    }

    public function setGroup($group) {
        $this->group = $group;
    }
    public function isAuthorized() {
        return $this->id !== null;
    }

    public function getHash() {
        return $this->hash;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function getLogin() {
        return $this->login;
    }

}
