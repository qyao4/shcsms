<?php
  require 'connect.php';

  $response = [
    "result" => "succ",
    "message" => "",
    "data" => []
  ];

  $vehicle_id = init_string('vehicle_id');
  
  if($vehicle_id == null){
    $response["result"] = "fail";
    $response["message"] = "wrong param.";
  }
  else  {
    $sql = "SELECT *
            FROM vehicles  
            WHERE vehicle_id = :vehicle_id";

    $statement = $db->prepare($sql);
    $statement->bindValue(':vehicle_id',$vehicle_id);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    
    // $response["data"] = $row;

    $sql = "SELECT * FROM comments WHERE vehicle_id = :vehicle_id and status IN (:status_s,:status_h) ORDER BY create_date DESC";
    $statement = $db->prepare($sql);
    $statement->bindValue(':vehicle_id',$vehicle_id);
    $statement->bindValue(':status_s',"S");
    $statement->bindValue(':status_h',"H");
    $statement->execute();
    $comments = [];
    while($comment = $statement->fetch(PDO::FETCH_ASSOC)){
      $comments[] = $comment;
    }
    
    $response["data"] = ["baseinfo"=>$row, "commentinfo"=>$comments];
  }
  $json = json_encode($response);
  header('Content-Type: application/json');
  echo $json;

  function init_string($key){
    if(isset($_POST[$key])){
      $ret = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
      if(!empty(trim($ret)))
          return $ret;
    }
    return null;
  }
?>