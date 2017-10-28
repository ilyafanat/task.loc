<?php

$fileName = $_GET['file'] ?? die('File not found');

header('Content-Length: ' . filesize($fileName));
header('Content-Type: application/octet-stream'); 
header('Content-Disposition: attachment; filename="' . basename($fileName) . '"'); 

readfile ($fileName);
flush();