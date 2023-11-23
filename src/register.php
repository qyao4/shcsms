<?php
  require 'connect.php';

  $response = [
    "result" => "succ",
    "message" => "",
    "data" => []
  ];
  
  $username = init_string('new_username');
  $email = init_string('new_email');
  $password = init_string('new_password');
  if($username !=null && $email != null && $password != null)
  {
    $sql = "SELECT * FROM users WHERE username = :username";
    $statement = $db->prepare($sql);
    $statement->bindValue(':username', $username);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    if($row == false){
      $sql = "INSERT INTO users (username,password,email) VALUES (:username,:password,:email)";
        $statement = $db->prepare($sql);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));
        $statement->bindValue(':email', $email);
        if(!$statement->execute())
          setFail('update failed.');
    }
    else
      setFail('This username has existed.');
  } 
  else{
    setFail('invalid request.');
  }
  $jsonData = json_encode($response);
  header('Content-Type: application/json');
  echo $jsonData; 
  
  function init_string($key){
    if(isset($_POST[$key])){
      $ret = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
      if(!empty(trim($ret)))
          return $ret;
    }
    return null;
  }

  function setFail($fail_msg){
    global $response;
    $response["result"] = "fail";
    $response['message'] = $fail_msg;
  }
?>