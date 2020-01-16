<?php declare(strict_types=1);

namespace App\Controller;

use PDO;
use App\Controller\ResponseController;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Container;

class MessageController extends ResponseController {
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

    public function getMessages()
    {
        $from_user = $this->request->getQueryParam('from_user');
        $uuid = $this->request->getQueryParam('uuid');

        if ($from_user === $uuid || empty($from_user) || empty($uuid)) {
            $this->respondWith(405, "An Error Occurred", "failed", $this->response);
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
                $this->respondWith(200, $data, "success", $this->response);
            } else {
                $this->resetConnection();
                $this->respondWith(201, array(), "success", $this->response);
            }
        } catch (Exception $e) {
            $this->resetConnection();
            $this->respondWith(400, "An Error Occurred", "failed", $this->response);
        }
    }

    public function saveMessage()
    {
        $message = $this->request->getParam('message');
        $to = $this->request->getParam('to');
        $from = $this->request->getParam('from');

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
                    $this->respondWith(201, array(), "success", $this->response);
                } else {
                    $this->resetConnection();
                    $this->respondWith(400, "An Error Occurred", "failed", $this->response);
                }
            } else {
                throw new Exception("An Error Occurred");
            }
        } catch (Exception $e) {
            $this->resetConnection();
            $this->respondWith(400, "An Error Occurred", "failed", $this->response);
        }
    }
}