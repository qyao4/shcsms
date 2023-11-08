<?php
  require 'connect.php';

  $response = [
    "result" => "succ",
    "message" => "",
    "data" => []
  ];

  $isValid = true;

  $sortField = init_string('sortField') ?? 'vehicle_id';
  $sortDirection = init_string('sortDirection') ?? 'DESC';

  if(!$isValid){
    $response["result"] = "fail";
    $response["message"] = "wrong param.";
  }
  else{
    $sql = "SELECT v.make, v.model, vc.category_name, v.year, v.price, v.mileage, v.exterior_color, 
              v.create_time, v.update_time,v.vehicle_id
            FROM vehicles v 
            INNER JOIN vehiclecategories vc ON vc.category_id = v.category_id";
    
    $keys = ['make','model','category_id'];
    $where_keys = [];
    $where_values = [];
    foreach($keys as $key){
      $val = init_string($key);
      if($val != null){
        if($key == 'category_id')
          $where_keys[] = "v.$key = :$key";
        else
          $where_keys[] = "$key = :$key";
        $where_values[$key] = $val;
      }
    }
    
    if(count($where_keys) > 0)
      $sql = $sql . " WHERE " . implode(" AND ", $where_keys);

    $sql = $sql . " ORDER BY {$sortField} {$sortDirection}";            

    //echo $sql;

    $statement = $db->prepare($sql);
    $statement->execute($where_values);
    // $statement->execute();
    while($row = $statement->fetch(PDO::FETCH_ASSOC)){
      // print_r($row);
      $results[] = $row;
    }
    $response["data"] = isset($results) ? $results: [];
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