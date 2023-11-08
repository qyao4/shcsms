<?php
  if (session_status() == PHP_SESSION_NONE)
    session_start();
  if(isset($_SESSION['user_logged_in'])){
    $user_logged_in = $_SESSION['user_logged_in'];
    $need_authenticated = false;
  }
?>