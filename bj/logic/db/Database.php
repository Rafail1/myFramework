<?php

namespace Logic\Db;

class Database {

    private static $instance;
    private $pdo;

    private function __construct() {
        $dsn = sprintf("mysql:host=localhost;dbname=%s;charset=%s", DBNAME, DBCHARSET);
        $opt = [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ];
        $this->pdo = new \PDO($dsn, DBUSER, DBPASS, $opt);
    }

    /**
     * @return \Logic\Db\Database 
     */
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getLastInsertId() {
        $stmt = $this->pdo->query("SELECT LAST_INSERT_ID()");
        $lastId = $stmt->fetch(\PDO::FETCH_NUM);
        return $lastId[0];
    }

    public function executeWithBind($sql, $params, $return) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $this->pdo->beginTransaction();
           
            foreach ($params as $name => $value) {
                if (!is_int($value)) {
                    $stmt->bindValue(":{$name}", $value);
                } else {
                    $stmt->bindValue(":{$name}", (int) $value, \PDO::PARAM_INT);
                }
            }
             
            $stmt->execute();
            $this->pdo->commit();
            if ($return) {
                return $stmt;
            }
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            return null;
        }
    }

    /**
     * @return \PDOStatement
     */
    public function execute($sql, $params, $return) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $this->pdo->beginTransaction();
            $stmt->execute($params);
            $this->pdo->commit();
            if ($return) {
                return $stmt;
            }
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            return null;
        }
    }

}
