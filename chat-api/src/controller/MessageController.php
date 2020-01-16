<?php declare(strict_types=1);

namespace App\Controller;

use PDO;
use App\Controller\ResponseController;
use App\Constants\HttpResponse;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Container;

class MessageController extends ResponseController
{
    private $request;
    private $response;

    public function __construct(?Request $request, ?Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    private function getMessageSQL(): String
    {
        return 'SELECT FROM_USER, MESSAGE, TO_USER, TIME FROM MESSAGES
        WHERE (FROM_USER = ? AND TO_USER = ?) OR (TO_USER = ? AND FROM_USER = ?)
        ORDER BY TIME ASC';
    }

    private function getSaveMessageSQL(): String
    {
        return 'INSERT INTO MESSAGES (FROM_USER, MESSAGE, TO_USER) VALUES (?,?,?)';
    }

    private function isUserIdUnique(String $from_user, String $uuid): bool
    {
        if ($from_user === $uuid || empty($from_user) || empty($uuid)) {
            return false;
        }
        return true;
    }

    public function getMessages()
    {
        $from_user = $this->request->getQueryParam('from_user');
        $uuid = $this->request->getQueryParam('uuid');

        if (!$this->isUserIdUnique($from_user, $uuid)) {
            return $this->respondWith(405, "An Error Occurred", HttpResponse::NOT_ALLOWED, $this->response);
        }

        try {
            $db = $this->getDBConnection();
            $query = $db->prepare($this->getMessageSQL());

            if ($query) {
                $query->bindValue(1, $from_user);
                $query->bindValue(2, $uuid);
                $query->bindValue(3, $from_user);
                $query->bindValue(4, $uuid);
                $query->execute();
                $data = $query->fetchAll(PDO::FETCH_ASSOC);

                $this->resetConnection();
                $this->respondWith(200, $data, HttpResponse::SUCCESS, $this->response);
            } else {
                $this->resetConnection();
                $this->respondWith(201, array(), HttpResponse::SUCCESS, $this->response);
            }
        } catch (Exception $e) {
            $this->resetConnection();
            $this->respondWith(400, "An Error Occurred", HttpResponse::BAD_REQUEST, $this->response);
        }
    }

    public function saveMessage()
    {
        $message = $this->request->getParam('message');
        $to = $this->request->getParam('to');
        $from = $this->request->getParam('from');

        if (!$this->isUserIdUnique($from, $to)) {
            return $this->respondWith(405, "An Error Occurred", HttpResponse::NOT_ALLOWED, $this->response);
        }

        try {
            if (!empty($message) && !empty($to) && !empty($from)) {
                $message = htmlspecialchars(strip_tags($message));

                $db = $this->getDBConnection();
                $query = $db->prepare($this->getSaveMessageSQL());
            
                if ($query) {
                    $query->bindValue(1, $from);
                    $query->bindValue(2, $message);
                    $query->bindValue(3, $to);
                    $query->execute();

                    $this->resetConnection();
                    $this->respondWith(201, array(), HttpResponse::SUCCESS, $this->response);
                } else {
                    $this->resetConnection();
                    $this->respondWith(400, "An Error Occurred", HttpResponse::BAD_REQUEST, $this->response);
                }
            } else {
                throw new Exception("An Error Occurred");
            }
        } catch (Exception $e) {
            $this->resetConnection();
            $this->respondWith(400, "An Error Occurred", HttpResponse::BAD_REQUEST, $this->response);
        }
    }
}