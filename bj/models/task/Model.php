<?php

/**
 * Description of Task
 *
 * @author raf
 */

namespace Models\Task;

class Model {

    private $db;
    private static $instance;
  

    const Q_GET_BY_ID = 'SELECT id, user_name, email, description, picture, done FROM tasks WHERE id = ?';
    const Q_GET = 'SELECT id, user_name, email, description, picture, done FROM tasks LIMIT :offset, :count';
    const Q_ADD = 'INSERT INTO tasks (id, user_name, email, description, picture) VALUES (NULL,?,?,?,?);';
    const Q_DELETE = 'DELETE FROM tasks WHERE id = ?';
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

    public function getOnePage($pageNum, $countOnPage) {
        $offset = ($pageNum-1) * $countOnPage;
        $stmt = $this->db->executeWithBind(self::Q_GET, ['offset' => (int)$offset, 'count' => (int)$countOnPage], true);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->execute(self::Q_GET_BY_ID, [$id], true);
        return $stmt->fetch();
    }

    public function createTask($data) {
        $this->db->execute(self::Q_ADD, [$data["user_name"], $data["email"], $data["description"], $data["picture"]]);

        $id = $this->db->getLastInsertId();
        if ($id) {
            return true;
        } else {
            return false;
        }
    }

    public function editTask($id, $fields) {
        $q = "UPDATE tasks SET ";
        $first = true;
        $keys = array_keys($fields);
        foreach ($keys as $name) {
            if ($first) {
                $first = false;
            } else {
                $q .= ",";
            }
            $q .= " {$name} = :{$name}";
        }
        $q .= " WHERE id = :id";
        $fields["id"] = $id;
        $stmt = $this->db->execute($q, $fields, true);

        if ($stmt != null && $stmt->rowCount()) {
            return true;
        }
        return false;
    }
    
    public function removeTask($id) {
        $stmt = $this->db->execute(self::Q_DELETE, [$id], true);
        if ( $stmt->rowCount()) {
            return true;
        }
        return false;
    }
    

    
    private function resizeImage($file, $size, $newSizes) {
        $w = $newSizes[0];
        $h = $newSizes[1];

        $r = $size[0] / $size[1];
        if ($w / $h > $r) {
            $newwidth = $h * $r;
            $newheight = $h;
        } else {
            $newheight = $w / $r;
            $newwidth = $w;
        }
        switch ($size[2]) {
            case IMAGETYPE_GIF:
                $src = imagecreatefromgif($file);
                break;
            case IMAGETYPE_JPEG:
                $src = imagecreatefromjpeg($file);
                break;
            case IMAGETYPE_PNG:
                $src = imagecreatefrompng($file);
                break;
        }

        $dst = imagecreatetruecolor($newwidth, $newheight);
        return imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $size[0], $size[1]);
    }

    public function addPicture($picture) {
        $valid_types = [IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG];
        $maxSize = [320, 240];
        $fileHelper = \Logic\Helper\FileHelper::getInstance();
        $size = getimagesize($picture['tmp_name']);

        if (!in_array($size[2], $valid_types)) {
            return "";
        }
        $name = $fileHelper->getName(UPLOAD_DIR . DIRECTORY_SEPARATOR . $picture['name']);
        if (!$fileHelper->copyFile($picture['tmp_name'], $name)) {
            return false;
        };
        if ($size[0] > $maxSize[0] || $size[1] > $maxSize[1]) {
            if ($this->resizeImage($name, $size, $maxSize)) {
                
            };
        }
        return $name;
    }

}
