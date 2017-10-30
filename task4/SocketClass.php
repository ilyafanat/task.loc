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
        
    }

    private function login()
    {
        
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