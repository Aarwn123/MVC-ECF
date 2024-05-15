<?php
class SPDO
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        $this->pdo = new \PDO("mysql:host=localhost:3306;dbname=cinema", "webuser", "123");
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getPdo()
    {
        return $this->pdo;
    }
}
