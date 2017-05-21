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

namespace Models\User;

class Model {

    private $db;
    private $user;
    private static $instance;

    const Q_GET_BY_HASH = 'SELECT id, login, password FROM users WHERE hash = ?';
    const Q_ADD = 'INSERT INTO users (id, login, password, hash) VALUES (NULL,?,?,?);';

    private function __construct() {
        $this->db = \Logic\Db\Database::getInstance();
    }

    /**
     * @return Model
     */
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function authByCookie() {
        global $USER;
        if ($h = filter_input(INPUT_COOKIE, 'uhsh')) {
            $uarr = $this->getByHash($h);
            if ($uarr) {
                $USER->setUser($uarr['id'], $uarr['login'], $uarr['password']);
            }
        }
    }

    private function getByHash($h) {
        $stmt = $this->db->execute(self::Q_GET_BY_HASH, [$h], true);
        return $stmt->fetch();
    }

    public function authUser($login, $password) {
        global $USER;
        $USER->setLogin($login);
        $USER->setPassword($password);
        $USER->generateHash();
        $uarr = $this->getByHash($USER->getHash());
        if ($uarr) {
            $USER->setId($uarr['id']);
            $this->remember();
        }
    }

    public function remember() {
        global $USER;
        setcookie('uhsh', $USER->getHash(), time() + 3600 * 24 * 365 * 2);
    }

    public function createUser($data) {
        global $USER;
        $USER->setLogin($data['login']);
        $USER->setPassword($data['password']);
        $USER->generateHash();
        $this->db->execute(self::Q_ADD, [$data['login'], $data['password'], $USER->getHash()]);
        $id = $this->db->getLastInsertId();
        if ($id) {
            $USER->setId($id);
            $this->remember();
            return true;
        } else {
             return false;
        }
    }

}
