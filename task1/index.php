<?php

$host = !empty($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'])['host'] : die('Referer not found');

setcookie('referrer', $host, 0, '/', $_SERVER['HTTP_REFERER']);

$fileName = preg_match('~.*/\K[^?\n]+~', $_SERVER['REQUEST_URI'], $matches) ? __DIR__ . '/' . $matches[0] : '';

if(!file_exists($fileName)) {
    die('File not found');
}

echo 'Download started';
echo '<iframe src="download.php?file=' . $fileName . '"></iframe>'; 