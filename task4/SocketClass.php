<?php

namespace SocketClass;
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

class SocketClass
{
    private static $INSTANCE = null;
    private $isLoggedIn = false;
    private $database = false;
    private $username, $password;

    private function __construct()
    {
        if(empty($_SERVER['PHP_AUTH_DIGEST'])) {
            $this->authentification();
            
        }
        $this->database = $this->databaseConnect();
        if (!$this->isLoggedIn) {
            $this->isLoggedIn = $this->login();
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
        $realm = 'Restricted area';
        header('HTTP/1.1 401 Unauthorized');
        header('WWW-Authenticate: Digest realm="'.$realm.
               '",qop="auth",nonce="'.uniqid().'",opaque="'.md5($realm).'"');
        die ("Not authorized");
    }

    private function login()
    {
        $stmt = $this->database->prepare('SELECT password FROM users WHERE username = ?');
        $stmt->execute([$this->username]);

        return password_verify($this->password, $stmt->fetchColumn()) ?: $this->logout();
    }

    private function logout()
    {
        var_dump($this->http_digest_parse($_SERVER['PHP_AUTH_DIGEST']));exit;
        unset($_SERVER['PHP_AUTH_DIGEST']);
        die('Password incorrect');
    }
    
    private function databaseConnect()
    {
        $db = new \PDO('mysql:host=localhost;dbname=tasks', 'root', '');
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

    private function http_digest_parse($txt)
    {
        // protect against missing data
        $needed_parts = array('nonce'=>1, 'nc'=>1, 'cnonce'=>1, 'qop'=>1, 'username'=>1, 'uri'=>1, 'response'=>1);
        $data = array();
        $keys = implode('|', array_keys($needed_parts));
    
        preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);
    
        foreach ($matches as $m) {
            $data[$m[1]] = $m[3] ? $m[3] : $m[4];
            unset($needed_parts[$m[1]]);
        }
    
        return $needed_parts ? false : $data;
    }
}