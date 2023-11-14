<?php
  require 'connect.php';

  $response = [
    "result" => "fail",
    "message" => "",
    "data" => []
  ];
  
  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
      $updatesJSON = isset($_POST['updates']) ? $_POST['updates'] : null;
      $createsJSON = isset($_POST['creates']) ? $_POST['creates'] : null;

      $updates = $updatesJSON ? json_decode($updatesJSON, true) : [];
      $creates = $createsJSON ? json_decode($createsJSON, true) : [];

      if (!empty($updates)) {
          foreach ($updates as $id => $value) {
            $sql = "UPDATE vehiclecategories SET category_name = :category_name WHERE category_id  = :category_id ";
            $statement = $db->prepare($sql);
            $statement->bindValue(':category_name',$value);
            $statement->bindValue(':category_id',$id);
            $statement->execute();
          }
      }

      if (!empty($creates)) {
          foreach ($creates as $id => $value) {
            //createCategory($id, $value);
            $sql = "INSERT INTO vehiclecategories (category_name) VALUES (:category_name) ";
            $statement = $db->prepare($sql);
            $statement->bindValue(':category_name',$value);
            $statement->execute();
          }
      }

      if (session_status() == PHP_SESSION_NONE)
          session_start();
      if (isset($_SESSION['categories']) )
          unset($_SESSION['categories']); 

      $response["result"] = "succ";
  }
  $jsonData = json_encode($response);
  header('Content-Type: application/json');
  echo $jsonData;  
?>