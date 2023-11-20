<?php
  require 'connect.php';

  $response = [
    "result" => "succ",
    "message" => "",
    "data" => []
  ];
  $command = init_string('command');
  $comment_id = init_string('comment_id');
  $vehicle_id = init_string('vehicle_id');
  if($command !=null && $comment_id != null && $vehicle_id != null)
  {
    if($command == 'Hide' || $command == 'Show'){
      $status = init_string('status');
      if($status != null){
        $sql = "UPDATE comments SET status = :status WHERE comment_id = :comment_id";
        $statement = $db->prepare($sql);
        $statement->bindValue(':status', $status);
        $statement->bindValue(':comment_id', $comment_id);
        if($statement->execute())
          getComments();
        else
          setFail('update failed.');
      }
      else
        setFail('invalid parameters.');
    }
    else if($command == 'Disemvowel'){
      $content = init_string('content');
      if($content != null){
        $sql = "UPDATE comments SET content = :content WHERE comment_id = :comment_id";
        $statement = $db->prepare($sql);
        $statement->bindValue(':content', $content);
        $statement->bindValue(':comment_id', $comment_id);
        if($statement->execute())
          getComments();
        else
          setFail('update failed.');
      }
      else
        setFail('invalid parameters.');
    }
    else if($command == 'Delete'){
      $sql = "DELETE FROM comments WHERE comment_id = :comment_id";
      $statement = $db->prepare($sql);
      $statement->bindValue(':comment_id', $comment_id);
      if($statement->execute())
        getComments();
      else
        setFail('delete failed.');
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

  function getComments(){
    global $db;
    global $vehicle_id;
    global $response;

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
    $response["data"] = ["commentinfo"=>$comments];
  }

  function setFail($fail_msg){
    global $response;
    $response["result"] = "fail";
    $response['message'] = $fail_msg;
  }
?>