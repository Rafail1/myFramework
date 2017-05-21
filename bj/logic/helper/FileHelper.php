<?php

namespace Logic\Helper;

class FileHelper {

    private static $instance;

    private function __construct() {
        
    }

    public function getExtension($fname) {
        preg_match('/\.([^.\s]{3,4})$/', $fname, $matches);
        if ($matches[1]) {
            return $matches[1];
        }
        return false;
    }

    /**
     * @return FileHelper 
     */
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getFileContent($fname, $unser) {
        if (file_exists($fname)) {
            if ($unser) {
                return unserialize(file_get_contents($fname));
            } else {
                return file_get_contents($fname);
            }
        } else {
            return false;
        }
    }

    public function getName($fname) {
        while (true) {
            if (!file_exists($fname)) {
                break;
            }
            preg_match("#\(([\d]*)\)\..{1,4}$#", $fname, $matches);
            if ($matches[1]) {
                $n = $matches[1] + 1;
                $fname = preg_replace("#(\([\d]*\))\.(.{1,4})$#", "($n).$2", $fname);
            } else {
                $n = 1;
                $fname = preg_replace("#(\..{1,4})$#", "($n)$1", $fname);
            }
        }

        return $fname;
    }

    function copyFile($from, $to) {
        if (copy($from, $to)) {
            return true;
        }
        return false;
    }

    function deleteFile($file) {
        unlink($file);
    }

    public function writeFile($fname, $content) {
        try {
            $fp = fopen($fname, "w");
            fwrite($fp, $content);
            fclose($fp);
        } catch (\Exception $ex) {
            echo $ex->getMessage();
            return false;
        }
        return true;
    }

}
