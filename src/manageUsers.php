<?php
  require 'connect.php';

  $response = [
    "result" => "succ",
    "message" => "",
    "data" => []
  ];
  $command = init_string('command');

  $dataJSON = isset($_POST['data']) ? $_POST['data'] : null;

  if($command !=null && !empty($dataJSON))
  {
    $data = json_decode($dataJSON, true);
    $user_id = $data['user_id'];
    if($command == 'Update'){
      $username = $data['username'];
      $email = $data['email'];
      
      if($username != null && $email != null){
        if($user_id != null){
          $sql = "UPDATE users SET username = :username, email = :email WHERE user_id = :user_id";
          $statement = $db->prepare($sql);
          $statement->bindValue(':username', $username);
          $statement->bindValue(':email', $email);
          $statement->bindValue(':user_id', $user_id);
          if(!$statement->execute())
            setFail('update failed.');
        }
        else{
          $sql = "INSERT INTO users (username,email,password) VALUES (:username,:email,:password)";
          $statement = $db->prepare($sql);
          $statement->bindValue(':username', $username);
          $statement->bindValue(':email', $email);
          $statement->bindValue(':password', password_hash('usercms', PASSWORD_DEFAULT));
          if(!$statement->execute())
            setFail('insert failed.');
        }
      }
      else
        setFail('invalid parameters.');
    }
    else if($command == 'Delete'){
      if($user_id !=null){
        $sql = "DELETE FROM users WHERE user_id = :user_id";
        $statement = $db->prepare($sql);
        $statement->bindValue(':user_id', $user_id);
        if(!$statement->execute())
          setFail('delete failed.');
      }
      else
        setFail('invalid parameters.');
    }
    else{
      setFail('wrong command.');
    }
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