<?php

require_once __DIR__ . '/SocketClass.php';

use SocketClass\SocketClass as Socket;

$socket = Socket::getInstance();

if ($socket->addUserInfo()) {
    
}
$phone = $socket->getUserPhone();
var_dump($socket->showPhone());exit;
