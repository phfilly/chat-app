<?php declare(strict_types=1);

namespace App\Controller;

use Slim\Container;
use Slim\Http\Response;
use db;

class BaseController
{
    private $db;

    // Keep JSON response consistent
    protected function jsonResponse(string $status, $message, int $statusCode)
    {
        $result = [
            'code' => $statusCode,
            'status' => $status,
            'message' => $message,
        ];
        return json_encode($result, JSON_PRETTY_PRINT);
    }

    // Connect to DB and save connection to variable
    protected function connect()
    {
        $this->db = new db();
        $this->db = $this->db->connect();
    }

    protected function getDBConnection()
    {
        $this->connect();
        return $this->db;
    }

    protected function resetConnection()
    {
        $this->db = null;
    }
}