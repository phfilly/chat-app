<?php
namespace App\Database;

// This caters for the possibility of swapping out this database adapter to something else.
interface DbConnectionInterface
{
    public function connect();
}
