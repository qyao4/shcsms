<?php
    /*******w******** 
    
    Name: Qiang Yao
    Date: 2023-11-27
    Description: validate and sanitize the data

    ****************/
/*
  if pass the check, return the value, or return null.
*/
function sanitize_post_string($field){
  if(!isset($_POST[$field]))
    return null;
  $res = filter_input(INPUT_POST,$field,FILTER_SANITIZE_SPECIAL_CHARS);
  return $res;
}

function validate_post_string_empty($field){
  $res = sanitize_post_string($field);
  if(!$res || empty(trim($res))) return null;
  return $res;
}

function validate_post_integer_valid($field){
  if(isset($_POST[$field]) && filter_input(INPUT_POST,$field,FILTER_VALIDATE_INT)){
    $res = $_POST[$field];
    return $res >= 0 ? $res : null;
  }
  return null;
}

function validate_post_email_valid($field){
  if(isset($_POST[$field]) && filter_input(INPUT_POST,$field,FILTER_VALIDATE_EMAIL)){
    $res = $_POST[$field];
    return $res;
  }
  return null;
}

function returnErrorMessage($message){
  $response['message'] = $message;
  header('Content-Type: application/json');
  $jsonData = json_encode($response);
  echo $jsonData;
  exit;
}


?>    