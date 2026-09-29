<?php

declare(strict_types=1);

namespace App;

use PDO;

class Database
{
    private static ?PDO $connection = null;

    public static function connection(): PDO
    {
        if (self::$connection === null) {
            $host = getenv('DB_HOST') ?: '127.0.0.1';
            $name = getenv('DB_NAME') ?: 'blog';
            $user = getenv('DB_USER') ?: 'blog';
            $password = getenv('DB_PASSWORD') ?: 'secret';

            self::$connection = new PDO(
                "mysql:host=$host;dbname=$name;charset=utf8mb4",
                $user,
                $password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        }

        return self::$connection;
    }
}
