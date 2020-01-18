<?php

use App\Database\DBConnectionInterface;

class db implements DbConnectionInterface
{
    public function connect() 
    {
        $db = new PDO('sqlite:..\src\database\chat.db');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    }
}