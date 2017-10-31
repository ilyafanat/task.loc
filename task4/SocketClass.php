<?php

namespace SocketClass;

/**
 * SocketClass main bussiness logic
 */

class SocketClass
{
    /**
    * instance of class
    * 
    */
    private static $INSTANCE = null;
    /**
    * variable of logged user
    * @var bool contains logged user information
    */
    private $isLoggedIn = false;
    /**
    * variable of database
    * @var bool contains connection to database
    */
    private $database = false;
    /**
    * variable of username
    * @var string contains username
    */
    private $username;
    /**
    * variable of password
    * @var string contains password
    */
    private $password;
    /**
    * variable of salt
    * @var string contains salt to encrypt data
    */
    private $salt = false;
    /**
    * variable of secret key
    * @var string contains secret key to encrypt data
    */
    private $secret = false;

    private function __construct()
    {
        $this->database = $this->databaseConnect();

        if (!$this->isLoggedIn) {
            $this->isLoggedIn = $this->authentification();
        }

        if (!$this->salt || !$this->secret) {
            $this->getSalt();
        }
    }

    /**
     * Construct an object of class
     *
     * @return instance of class
     */
    public static function getInstance()
    {
        if (self::$INSTANCE === null) {
            self::$INSTANCE = new self();
        }

        return self::$INSTANCE;
    }

    /**
     * Authentificate user
     *
     * @return bool password verify
     */
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

    /**
     * Redirect to login page
     *
     */
    private function login()
    {
        header('Location: /task4/login.php');
    }

    /**
     * Get salt of hash password and secret
     *
     * @return string salt and secret
     */
    private function getSalt()
    {
        $stmt = $this->database->prepare('SELECT password, secret FROM users WHERE username = "admin"');
        $stmt->execute();

        $this->salt = $stmt->fetch()['password'];
        $this->secret = $stmt->fetch()['secret'];
    }

     /**
     * Insert hashed phone and email to database
     *
     * @return bool of inserted value
     */
    public function addUserInfo() {
        $phone = $_POST['phone'] ?: '80668828904';
        $email = $_POST['email'] ?: 'ilyafanat@mail.ru';

        if (empty($phone) || empty($email)) {
            return $this->showUserInfo();
        }

        $stmt = $this->database->prepare('INSERT INTO user_info (phone, email) VALUES (?, ?)');
        $stmt->execute([$this->encrypt($phone), $this->encrypt($email)]);

        return true;
    }

    /**
     * Redirect to user information page
     *
     */
    private function showUserInfo()
    {
        header('Location: /task4/userInfo.php');
    }

    /**
     * Select phone by email
     *
     * @return string decrypted phone number
     */
    public function getUserPhone() {
        $email = $_POST['email'] ?: '';

        if (empty($email)) {
            return $this->showUserInfo();
        }

        $stmt = $this->database->prepare('SELECT phone FROM user_info WHERE email = ?');
        $stmt->execute([$this->encrypt($email)]);

        return $this->decrypt($stmt->fetchColumn());
    }

    /**
     * Encrypt string
     *
     *  @param string $string 
     * 
     *  @return string encrypted string
     */
    private function encrypt($string)
    {
        $encryptMethod = 'AES-256-CBC';

        $key    = hash('sha256', $this->salt);
        $iv     = substr(hash("sha256", 'admin'), 0, 16);
        
        return base64_encode(openssl_encrypt($string, $encryptMethod, $key, 0, $iv));
    }

    /**
     * Decrypt string
     *
     *  @param string $string 
     * 
     *  @return string decrypted string
     */
    private function decrypt($string)
    {
        $encryptMethod = 'AES-256-CBC';

        $key = hash('sha256', $this->salt);
        $iv = substr(hash("sha256", 'admin'), 0, 16);

        return openssl_decrypt(base64_decode($string), $encryptMethod, $key, 0, $iv);
    }

    /**
     * Create connection to database
     *
     *  @return object connection to database
     */
    private function databaseConnect()
    {
        $db = new \PDO('mysql:host=localhost;dbname=tasks;', 'root', '');
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        // $db->exec('CREATE DATABASE IF NOT EXISTS `tasks`; USE `tasks`;');
        // $db->exec('CREATE TABLE IF NOT EXISTS `users`(
        //     `id` int(11) NOT NULL AUTO_INCREMENT,
        //     `username` varchar(255) NOT NULL,
        //     `password` varchar(255) NOT NULL,
        //     `secret` varchar(255) NOT NULL,
        //     PRIMARY KEY (`id`)
        // ) ENGINE=InnoDB;
        // CREATE TABLE IF NOT EXISTS `user_info`(
        //     `id` int(11) NOT NULL AUTO_INCREMENT,
        //     `phone` varchar(255) NOT NULL,
        //     `email` varchar(255) NOT NULL,
        //     PRIMARY KEY (`id`)
        // ) ENGINE=InnoDB;');

        // $db->exec('INSERT INTO users (`username`, `password`, `secret`) VALUES("admin", "'.password_hash("admin123", PASSWORD_DEFAULT).'", "'.password_hash("secretkey", PASSWORD_DEFAULT).'");');
        return $db;
    }
}