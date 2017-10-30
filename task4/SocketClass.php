<?php

namespace SocketClass;
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

class SocketClass
{
    private static $INSTANCE = null;
    private $isLoggedIn = false;
    private $database = false;
    private $username, $password, $phone, $email;
    private $salt = false;

    private function __construct()
    {
        $this->database = $this->databaseConnect();

        if (!$this->isLoggedIn) {
            $this->isLoggedIn = $this->authentification();
        }

        if (!$this->salt) {
            $this->salt = $this->getSalt();
        }
    }

    public static function getInstance()
    {
        if (self::$INSTANCE === null) {
            self::$INSTANCE = new self();
        }

        return self::$INSTANCE;
    }

    private function authentification()
    {
        $this->username = $_POST['username'] ?: '';
        $this->password = $_POST['password'] ?: '';

        if (empty($this->username) || empty($this->password)) {
            return $this->login();
        }

        $stmt = $this->database->prepare('SELECT password FROM users WHERE username = ?');
        $stmt->execute([$this->username]);

        return password_verify($this->password, $stmt->fetchColumn()) ?: $this->login();
    }

    private function login()
    {
        header('Location: /task4/login.php');
    }

    private function getSalt()
    {
        $stmt = $this->database->prepare('SELECT password FROM users WHERE username = "admin"');
        $stmt->execute();

        return $this->salt = $stmt->fetchColumn();
    }

    public function addPhone() {
        $phone = $_POST['phone'] ?: '80668828904';
        $email = $_POST['email'] ?: 'ilyafanat@mail.ru';

        if (empty($phone) || empty($email)) {
            return $this->showAddPhone();
        }

        $stmt = $this->database->prepare('INSERT INTO user_info (phone, email) VALUES (?, ?)');
        $stmt->execute([$this->encrypt($phone), $this->encrypt($email)]);

        return true;
    }

    private function showAddPhone()
    {
        header('Location: /task4/addphone.php');
    }

    public function showPhone() {
        $email = $_POST['email'] ?: 'ilyafanat@mail.ru';

        if (empty($email)) {
            return $this->showAddPhone();
        }

        $stmt = $this->database->prepare('SELECT phone FROM user_info WHERE email = ?');
        $stmt->execute([$this->encrypt($email)]);

        return $this->decrypt($stmt->fetchColumn());
    }

    private function encrypt($string)
    {
        $encryptMethod = 'AES-256-CBC';

        $key    = hash('sha256', $this->salt);
        $iv     = substr(hash("sha256", 'admin'), 0, 16);
        
        return base64_encode(openssl_encrypt($string, $encryptMethod, $key, 0, $iv));
    }

    private function decrypt($string)
    {
        $encryptMethod = 'AES-256-CBC';

        $key = hash('sha256', $this->salt);
        $iv = substr(hash("sha256", 'admin'), 0, 16);

        return openssl_decrypt(base64_decode($string), $encryptMethod, $key, 0, $iv);
    }

    private function databaseConnect()
    {
        $db = new \PDO('mysql:host=localhost;dbname=tasks;', 'root', 'root');
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        // $db->exec('CREATE DATABASE IF NOT EXISTS `tasks`; USE `tasks`;');
        // $db->exec('CREATE TABLE IF NOT EXISTS `users`(
        //     `id` int(11) NOT NULL AUTO_INCREMENT,
        //     `username` varchar(255) NOT NULL,
        //     `password` varchar(255) NOT NULL,
        //     PRIMARY KEY (`id`)
        // ) ENGINE=InnoDB;
        // CREATE TABLE IF NOT EXISTS `user_info`(
        //     `id` int(11) NOT NULL AUTO_INCREMENT,
        //     `phone` varchar(255) NOT NULL,
        //     `email` varchar(255) NOT NULL,
        //     PRIMARY KEY (`id`)
        // ) ENGINE=InnoDB;');

        // $db->exec('INSERT INTO users (`username`, `password`) VALUES("admin", "'.password_hash("admin123", PASSWORD_DEFAULT).'");');
        return $db;
    }
}