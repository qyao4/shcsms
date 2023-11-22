<?php
    /*******w******** 
    
    Name: Qiang Yao
    Date: 2023-11-22
    Description: Home Header Showed in Every Page

    ****************/
    $need_authenticated = false; //non-administrative

   
    
    if(isset($_GET['action']) && $_GET['action'] === 'logout'){
        if (session_status() == PHP_SESSION_NONE)
            session_start();
        if (isset($_SESSION['user_logged_in']) )
            unset($_SESSION['user_logged_in']); 
    }
    
    // Get category options
    require('category_getter.php');
    // var_dump(CATEGORY_OPTIONS);
?>