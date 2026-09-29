<?php

// запуск без Docker: php -S localhost:8000 server.php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if ($path !== '/' && is_file(__DIR__ . '/public' . $path)) {
    return false; // статичные файлы встроенный сервер отдаёт сам
}

require __DIR__ . '/public/index.php';
