<?php

namespace SocketClass;

class SocketClass
{
    private static $INSTANCE = null;
    private $isLoggedIn = false;
    private $database = false;

    private function __construct()
    {
        if (!$this->isLoggedIn) {
            $this->isLoggedIn = $this->login();
        }

        $this->database = $this->databaseConnect();
    }

    public static function getInstance()
    {
        if (self::$INSTANCE === null) {
            self::$INSTANCE = new self();
        }

        return self::$INSTANCE;
    }

    public function test()
    {
        
    }

    private function authentification()
    {
        var_dump($_SERVER);exit;
        if (empty($_SERVER['PHP_AUTH_USER'])) {
            header('WWW-Authenticate: Basic realm="Restricted area"');
            header('HTTP/1.0 401 Unauthorized');
            die ("Not authorized");
        }

        
    }

    private function login()
    {
        $username = $_SERVER['PHP_AUTH_USER'];
        $password = $_SERVER['PHP_AUTH_PW'];

        // var_dump($this->database);exit;
    }

    private function databaseConnect()
    {
        $db = new \PDO('mysql:host=localhost', 'root', 'root');
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $db->exec('CREATE DATABASE IF NOT EXISTS `tasks`; USE `tasks`;');
        $this->database->exec('CREATE TABLE IF NOT EXISTS `users`(
            id` int(11) NOT NULL AUTO_INCREMENT,
            `username` varchar(255) NOT NULL,
            `password` varchar(255) NOT NULL,
            PRIMARY KEY (`id`),
        ) ENGINE=InnoDB;
        CREATE TABLE IF NOT EXISTS `users`(
            id` int(11) NOT NULL AUTO_INCREMENT,
            `username` varchar(255) NOT NULL,
            `password` varchar(255) NOT NULL,
            PRIMARY KEY (`id`),
        ) ENGINE=InnoDB;');
        return $db;
    }

    private function createTables()
    {
        try {
            $this->database->exec('CREATE DATABASE IF NOT EXISTS `tasks`;
                                    USE `tasks`;');
        } catch (PDOException $e) {
            die("DB ERROR: ". $e->getMessage());
        }

    }
}