<?php
  require 'connect.php';

  $response = [
    "result" => "succ",
    "message" => "",
    "data" => []
  ];

  if(isset($_POST['command'])){
    $command = $_POST['command'];
    $vehicle_id = init_string('vehicle_id');

    if($vehicle_id == null){
      $response["result"] = "fail";
      $response["message"] = "wrong param.";
    }
    else{
      if($command == 'View'){
        $sql = "SELECT v.make, v.model, vc.category_name, v.year, v.price, v.mileage, v.exterior_color, 
                v.create_time, v.update_time,v.vehicle_id,v.description
              FROM vehicles v 
              INNER JOIN vehiclecategories vc ON vc.category_id = v.category_id
              WHERE vehicle_id = :vehicle_id";           

        $statement = $db->prepare($sql);
        $statement->bindValue(':vehicle_id',$vehicle_id);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT * FROM comments WHERE vehicle_id = :vehicle_id ORDER BY create_date DESC";
        $statement = $db->prepare($sql);
        $statement->bindValue(':vehicle_id',$vehicle_id);
        $statement->execute();
        $comments = [];
        while($comment = $statement->fetch(PDO::FETCH_ASSOC)){
          $comments[] = $comment;
        }
        
        $response["data"] = ["baseinfo"=>$row, "commentinfo"=>$comments];
      }
      else if($command == 'Submit'){
        $username = init_string('name') ?? 'Anonymous';
        $content = init_string('content');
        if(!empty(trim($content))){
          $sql = "INSERT INTO comments (username,content,vehicle_id) VALUES (:username,:content,:vehicle_id)";
          $statement = $db->prepare($sql);
          $statement->bindValue(':username', $username);
          $statement->bindValue(':content',$content);
          $statement->bindValue(':vehicle_id',$vehicle_id);
          $statement->execute();
        }
        else{
          $response['result'] = 'fail.';
          $response['message'] = 'content is empty.';
        }
      }
      else{
        $response['result'] = 'fail.';
        $response['message'] = 'wrong command[view vehicle].';
      }
    }
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