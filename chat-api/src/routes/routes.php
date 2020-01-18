<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use App\Controller\MessageController;
use App\Controller\ResponseController;
use App\Constants\HttpResponse;

$app->get('/api/messages', function (Request $request, Response $response, array $args) {
    $message = new MessageController($request, $response);
    $message->getMessages();
});

$app->post('/api/messages', function (Request $request, Response $response, array $args) {
    $message = new MessageController($request, $response);
    $message->saveMessage();
});