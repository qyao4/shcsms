<?php
    /*******w******** 
    
    Name: Qiang Yao
    Date: 2023-11-22
    Description: Home Header Showed in Every Page

    ****************/
    // $links = [
    //   "signin"=>true,
    //   "signup"=>true,
    //   "logout"=>true,
    // ];
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="#">SHCSMS<?= isset($_SESSION['user_logged_in']) ? '-'.$_SESSION['user_logged_in'] : '' ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>        
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
            
            <?php if(isset($links['signin']) && $links['signin']): ?>
            <li class="nav-item">
                <a id="navAdmin" class="nav-link" href="#" data-toggle="modal" data-target="#loginModal">Sign in</a>
            </li>
            <?php endif ?>

            <?php if(isset($links['signup']) && $links['signup']): ?>
            <li class="nav-item">
                <a class="nav-link" href="register.php">Sign up</a>
            </li>
            <?php endif ?>

            <?php if(isset($links['logout']) && $links['logout']): ?>
            <li class="nav-item">
                <a class="nav-link" href="index.php?action=logout">Logout</a>
            </li>
            <?php endif ?>
        </ul>
    </div>
</nav>