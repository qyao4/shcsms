<?php
  require 'connect.php';

  $response = [
    "result" => "succ",
    "message" => "",
    "data" => []
  ];

  $vehicle_id = init_string('vehicle_id');
  $slug = init_string('slug');
  
  if($vehicle_id == null || $slug == null){
    $response["result"] = "fail";
    $response["message"] = "wrong param.";
  }
  else  {
    $sql = "SELECT *
            FROM vehicles  
            WHERE vehicle_id = :vehicle_id AND slug=:slug ";

    $statement = $db->prepare($sql);
    $statement->bindValue(':vehicle_id',$vehicle_id);
    $statement->bindValue(':slug',$slug);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    
    if($row == false){
      $response["result"] = "fail";
      $response["message"] = "no vehicle found.";
    }
    else{
      // Get comments
      $sql = "SELECT * FROM comments WHERE vehicle_id = :vehicle_id AND status IN (:status_s,:status_h) ORDER BY create_date DESC";
      $statement = $db->prepare($sql);
      $statement->bindValue(':vehicle_id',$vehicle_id);
      $statement->bindValue(':status_s',"S");
      $statement->bindValue(':status_h',"H");
      $statement->execute();
      $comments = [];
      while($comment = $statement->fetch(PDO::FETCH_ASSOC)){
        $comments[] = $comment;
      }

      // Get Images
      $sql = "SELECT * FROM vehicleimages WHERE vehicle_id = :vehicle_id ";
      $statement = $db->prepare($sql);
      $statement->bindValue(':vehicle_id',$vehicle_id);
      $statement->execute();
      $images = [];
      while($image = $statement->fetch(PDO::FETCH_ASSOC)){
        $images[] = $image;
      }
    }
    $response["data"] = ["baseinfo"=>$row, "commentinfo"=>$comments, "imageinfo"=>$images];
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