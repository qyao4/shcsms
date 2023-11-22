<?php
  require 'connect.php';

  $response = [
    "result" => "succ",
    "message" => "",
    "data" => []
  ];

  $sql = "SELECT * FROM users ";           
  $statement = $db->prepare($sql);
  $statement->execute();
  $users = [];
  while($user = $statement->fetch(PDO::FETCH_ASSOC)){
    $users[] = $user;
  }
  $response["data"] = $users;
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