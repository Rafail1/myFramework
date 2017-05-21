<?php

/**
 * Description of Task
 * @author raf
 */

namespace Models\Task\Entity;

class Task {

    private $userName;
    private $email;
    private $description;
    private $picture;

    protected function __construct($userName, $email, $description, $picture) {
        $this->userName = $userName;
        $this->email = $email;
        $this->description = $description;
        $this->picture = $picture;
    }
  
    public function getUserName() {
        return $this->userName;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function getDescription() {
        return $this->description;
    }
   
    public function getPicture() {
        return $this->picture;
    }

}
