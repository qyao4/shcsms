<?php
  if (session_status() == PHP_SESSION_NONE)
    session_start();
  if(isset($_SESSION['user_logged_in']) && isset($_SESSION['permission'])){
    $user_logged_in = $_SESSION['user_logged_in'];
    $permission = $_SESSION['permission'];
    $need_authenticated = $_SESSION['permission']!='9'; // false;
  }
?>