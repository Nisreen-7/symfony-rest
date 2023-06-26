<?php

namespace App\Repository;

class Database
{

    public static function getConnection()
    {
        return new \PDO("mysql:host=localhost;dbname=symfony_rest", "root", "@nisreen123456@");

    }
}