<?php

    // This caters for the possibility of swapping out this database adapter to something else.
    interface DbConnectionInterface
    {
        public function connect();
    }

    class db implements DbConnectionInterface
    {
        public function connect() 
        {
            $db = new PDO('sqlite:..\src\database\chat.db');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        }
    }