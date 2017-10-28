<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/SocketClass.php';

use SocketClass;

$socket = SocketClass\SocketClass::getInstance();

// $socket->test();

