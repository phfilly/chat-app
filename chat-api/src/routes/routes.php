<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use App\Controller\MessageController;

$app = new \Slim\App;
$app->get('/api/messages', function (Request $request, Response $response, array $args) {
    try {
        $message = new MessageController($request, $response);
        return $message->getMessages();
    } catch (Exception  $e) {
        return $response->withStatus(400)
        ->withHeader('Content-Type', 'application/json')
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->write('Error occurred');
    }
});

$app->post('/api/messages', function (Request $request, Response $response, array $args) {
    try {
        $message = new MessageController($request, $response);
        return $message->saveMessage();
    } catch (PDOException  $e) {
        return $response->withStatus(400)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->write('Error occurred');
    }
});