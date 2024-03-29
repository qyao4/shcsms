<?php
    /*******w******** 
    
    Name: Qiang Yao
    Date: 2023-11-22
    Description: Home Header Showed in Every Page

    ****************/
    // $links = [
    //   "home"=>"index.php"    
    //   "signin"=>true,
    //   "signup"=>true,
    //   "logout"=>true,
    // ];
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="<?= isset($links['home']) ? $links['home'] : 'home/'?>">SHCSMS<?= isset($_SESSION['user_logged_in']) ? '-'.$_SESSION['user_logged_in'] : '' ?></a>
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

            <?php if(isset($links['new']) && $links['new']): ?>
            <li class="nav-item active">
                <a class="nav-link" href="new.php">CreateNew <span class="sr-only">(current)</span></a>
            </li>
            <?php endif ?>

            <?php if(isset($links['categories']) && $links['categories']): ?>
            <li class="nav-item">
                <a class="nav-link" href="categories.php">Categories</a>
            </li>
            <?php endif ?>

            <?php if(isset($links['users']) && $links['users']): ?>
            <li class="nav-item">
                <a class="nav-link" href="users.php">Users</a>
            </li>
            <?php endif ?>

            <?php if(isset($links['logout']) && $links['logout']): ?>
            <li class="nav-item">
                <a class="nav-link" href="home/logout/">Logout</a>
            </li>
            <?php endif ?>

        </ul>
    </div>
</nav>