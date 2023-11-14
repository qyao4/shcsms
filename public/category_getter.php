<?php
/*******w******** 
  Name: Qiang Yao
  Date: 2023-11-07
  Description: get categories of all the vehicles.
****************/
  if (session_status() == PHP_SESSION_NONE)
    session_start();
  require __DIR__ . '/../src/connect.php';
  
  
  if (!isset($_SESSION['categories'])){
    $stmt = $db->prepare("SELECT category_id, category_name FROM vehiclecategories ORDER BY category_id");
    $stmt->execute();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      // print_r($row);
      $results[] = $row;
    }
    $_SESSION['categories'] = $results;
  }

  define("CATEGORY_OPTIONS", $_SESSION['categories']);

?>
