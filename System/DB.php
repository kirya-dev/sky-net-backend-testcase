<?php

namespace System;


class DB
{
    public static function connection()
    {
        static $pdo;
        if (! $pdo) {
            $pdo = new \PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
            $pdo->exec('SET NAMES utf8');
        }

        return $pdo;
    }
}
