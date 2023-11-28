<?php
    /*******w******** 
    Name: Qiang Yao
    Date: 2023-11-13
    Description: Register new user
    ****************/
    // Authenticate
    $need_authenticated = false; 
    require('authenticate.php');

    $links = [
        "signin"=>false,
        "signup"=>false,
        "logout"=>isset($_SESSION['user_logged_in']),
    ];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="register.js"></script>
    <title>Welcome to SHCSMS</title>
</head>
<body>
    <!-- Header -->
    <?php include('header.php'); ?>

    <div id="container" class="container mt-5">
        <h2>User Registration</h2>
        <!-- Registration Form -->
        <form id="registrationForm" class="needs-validation">
            <div class="form-group">
                <label for="new_username">Username</label>
                <input type="text" class="form-control" id="new_username" name="new_username" placeholder="Choose a username" required>
            </div>
            <div class="form-group">
                <label for="new_email">Email Address</label>
                <input type="email" class="form-control" id="new_email" name="new_email" placeholder="Enter email" required>
            </div>
            <div class="form-group">
                <label for="new_password">Password</label>
                <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <label for="new_confirmPassword">Confirm Password</label>
                <input type="password" class="form-control" id="new_confirmPassword" name="new_confirmPassword" placeholder="Confirm Password" required>
            </div>
            <div class="form-group text-right">
                <button type="submit" class="btn btn-primary">Register</button>
            </div>
        </form>
    </div>


    <!-- Footer -->
    <?php include('footer.php'); ?>
    <?php include('signin.php'); ?>
</body>
</html>