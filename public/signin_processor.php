<?php
/*******w******** 
  Name: Qiang Yao
  Date: 2023-11-07
  Description: process and authenticate log in.
****************/
  if (session_status() == PHP_SESSION_NONE)
    session_start();
  
  require __DIR__ . '/../src/connect.php';
  $errorMessage = "Authentication Failed.";
  
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = init_username();
    $password = init_password();

    if($username!=null && $password!=null){
      $stmt = $db->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
      $stmt->bindValue("username", $username);
      $stmt->bindValue("password", $password);
      $stmt->execute();

      if ($stmt->rowCount() > 0) {
        $_SESSION['user_logged_in'] = $username;
        if(isset($_POST['type']) && $_POST['type'] == 'login'){
          header("Location: admin.php");
        }
        else{
          if(isset($_SERVER['HTTP_REFERER'])){
            $returnUrl = $_SERVER['HTTP_REFERER'];
            header('Location: ' . $returnUrl);
          }
        }
        exit;
      }
    }
  }

  function init_username(){
    if(isset($_POST['username'])){
      $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
      if(!empty(trim($username)))
          return $username;
    }
    return null;
  }

  function init_password(){
    if(isset($_POST['password'])){
      $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
      if(!empty(trim($password)))
          return $password;
    }
    return null;
  }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Process Post</title>
</head>
<body>
    <div id="message_area">
      <h1>An error occured.</h1>
      <p><?= $errorMessage ?></p>
      <a href="index.php">Return Home</a>
    </div>
</body>
</html>