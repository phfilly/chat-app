<?php
    include "../controllers/connect.php";
    try {
      $sql = "
        CREATE TABLE IF NOT EXISTS MESSAGES 
        (ID INTEGER PRIMARY KEY AUTOINCREMENT,
        FROM_USER TEXT NOT NULL,
        MESSAGE TEXT NOT NULL,
        TO_USER TEXT NOT NULL,
        TIME DATETIME DEFAULT CURRENT_TIMESTAMP)";
      
      $ret = $db->exec($sql);
      echo "Database created successfully!";

    } catch (PDOException  $e) {
      echo $e->getMessage();
    }

    $db = null;
?>