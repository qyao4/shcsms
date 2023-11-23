<?php
    /*******w******** 
    Name: Qiang Yao
    Date: 2023-11-13
    Description: Users Administration (administrative)
    ****************/
    // Authenticate
    $need_authenticated = true; 
    require('authenticate.php');

    $links = [
        "home"=>'admin.php',
    ];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script language="javascript" src="users.js"></script>
    <title>Welcome to SHCSMS</title>
    <style>
        
    </style>
</head>
<body class="green-theme">
    <!-- Header -->
    <?php include('header.php'); ?>

    <div id="container" class="container mt-5">
        <h2>User Admin</h2>
        <form id="userForm">
            <table class="table">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="userTableBody">
                </tbody>
            </table>
            <button type="button" class="btn btn-primary" id="addRow">Add New User</button>
            <!-- <button type="submit" class="btn btn-success">Save Changes</button> -->
        </form>
    </div>

    <!-- Footer -->
    <?php include('footer.php'); ?>
    <?php include('signin.php'); ?>
</body>
</html>