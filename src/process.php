<?php
  require 'connect.php';

  $response = [
    "result" => "fail",
    "message" => "",
    "data" => []
  ];
  
  if(isset($_POST['command']))
  {
    $command = $_POST['command'];
    if($command == 'Create'){
      $sql = "INSERT INTO Vehicles (make,model,year,price,mileage,exterior_color,description,category_id,slug)  
      VALUES (:make,:model,:year,:price,:mileage,:exterior_color,:description,:category_id,:slug)";
      $statement = $db->prepare($sql);
      $statement->bindValue(':make', $_POST['make']);
      $statement->bindValue(':model',$_POST['model']);
      $statement->bindValue(':year',$_POST['year']);
      $statement->bindValue(':price',$_POST['price']);
      $statement->bindValue(':mileage',$_POST['mileage']);
      $statement->bindValue(':exterior_color',$_POST['exterior_color']);
      $statement->bindValue(':description',$_POST['description']);
      $statement->bindValue(':category_id',$_POST['category_id']);
      $statement->bindValue(':slug',str_replace(' ', '-',$_POST['slug']));
      //  Execute the INSERT.
      if($statement->execute()){
        $response["result"] = "succ";
      }
    }
    else if($command == 'Update'){
      //  Execute the UPDATE.
      $fields = ['make','model','year','price','mileage','exterior_color','description','category_id','slug'];
      $update_fields = [];
      $bind_values = [];
      foreach($fields as $field){
        if(isset($_POST[$field])){
          $update_fields[] = "$field = :$field";
          $bind_values[$field] = $field == 'slug' ? str_replace(' ', '-',$_POST[$field]) : $_POST[$field];
        }
      }
      $sql = "UPDATE vehicles SET ". implode(" , ", $update_fields) . " WHERE vehicle_id = :vehicle_id";
      $bind_values['vehicle_id'] = $_POST['vehicle_id'];
      $statement = $db->prepare($sql);
      
      if($statement->execute($bind_values)){
        $response["result"] = "succ";
        $response["data"] = ["slug"=>str_replace(' ', '-',$_POST[$field])];
      }
    }
    else if($command == 'Delete'){
      $sql = "DELETE FROM Vehicles WHERE vehicle_id = :vehicle_id";
      $statement = $db->prepare($sql);
      $statement->bindValue(':vehicle_id',$_POST['vehicle_id']);
      //  Execute the DELETE.
      if($statement->execute()){
        $response["result"] = "succ";
      }
    }
    else{
      $response['message'] = 'wrong command.';
    }
  }
  $jsonData = json_encode($response);
  header('Content-Type: application/json');
  echo $jsonData;  
?>