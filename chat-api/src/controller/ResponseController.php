<?php declare(strict_types=1);

namespace App\Controller;

use \Psr\Http\Message\ResponseInterface as Response;

class ResponseController extends BaseController {
    private $statusCode;
    private $data;

    public function __construct(int $statusCode = 200, $data = null)
    {
        $this->statusCode = $statusCode;
        $this->data = $data;
    }

    public function respondWith(int $statusCode, $payload, string $status, Response $response): Response
    {
        $response->getBody()->write($this->jsonResponse($status, $payload, $statusCode));
        return $response->withHeader('Access-Control-Allow-Origin', '*');
    }
}