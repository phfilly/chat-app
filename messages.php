<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    try {

      if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        retrieveMessages();
      } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        saveMessage();
      } else {
        errorResponse();
      }
      
    } catch (PDOException  $e) {
      return errorResponse();
    }

  $db = null;

  function saveMessage() {
    include "connect.php";
    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->message) && !empty($data->to) && !empty($data->from)) {
      $data->message = htmlspecialchars(strip_tags($data->message));

      $query = "INSERT INTO MESSAGES (FROM_USER, MESSAGE, TO_USER) VALUES ('$data->from', '$data->message', '$data->to')";
      $db->exec($query);
      http_response_code(201);
    } else {
      throw new Exception('empty data');
    }
  }

  function retrieveMessages() {
    include "connect.php";
    $data = json_decode(file_get_contents("php://input"));

    if ($_GET['from_user'] === $_GET['uuid']) {
      throw new Exception('error occurred');
    }

    $sql = 'SELECT FROM_USER, MESSAGE, TO_USER, TIME FROM MESSAGES
      WHERE (FROM_USER = ? AND TO_USER = ?) OR (TO_USER = ? AND FROM_USER = ?)
      ORDER BY TIME ASC';
    
    $query = $db->prepare($sql);
    if ($query) {
      $query->bindValue(1, $_GET['from_user']);
      $query->bindValue(2, $_GET['uuid']);
      $query->bindValue(3, $_GET['from_user']);
      $query->bindValue(4, $_GET['uuid']);
      $query->execute();
      $data = $query->fetchAll(PDO::FETCH_ASSOC);
      http_response_code(200);
      echo json_encode($data);
    } else {
      http_response_code(200);
      echo json_encode(array());
    }
  }

  function errorResponse() {
    http_response_code(400);
    echo json_encode(array("message" => "Error occurred"));
  }
?>