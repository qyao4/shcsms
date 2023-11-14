<?php
    /*******w******** 
    Name: Qiang Yao
    Date: 2023-11-13
    Description: Update vehicle Categories (administrative)
    ****************/
    // Authenticate
    $need_authenticated = true; 
    require('authenticate.php');

    // Get category options
    require('category_getter.php');
    // var_dump(CATEGORY_OPTIONS);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script language="javascript" src="categories.js"></script>
    <title>Welcome to SHCSMS</title>
    <style>
        
    </style>
</head>
<body class="green-theme">
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="admin.php">SHCSMS</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <!-- <a id="navAdmin" class="nav-link" href="#">Save</a> -->
                </li>
            </ul>
        </div>
    </nav>

    <div id="container" class="container mt-5">
        <h2>Vehicle Categories</h2>
        <form id="categoryForm">
            <table class="table">
                <thead>
                    <tr>
                        <th>Category ID</th>
                        <th>Category Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="categoryTableBody">
                    <?php foreach (CATEGORY_OPTIONS as $category): ?>
                        <tr>
                            <td><?= htmlspecialchars($category['category_id']) ?></td>
                            <td><input type='text' class='form-control' edit_type='update'
                                name='<?= htmlspecialchars($category['category_id']) ?>' 
                                org_value='<?= htmlspecialchars($category['category_name']) ?>'
                                value='<?= htmlspecialchars($category['category_name']) ?>'></td>
                            <td></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="button" class="btn btn-primary" id="addRow">Add New Category</button>
            <button type="submit" class="btn btn-success">Save Changes</button>
        </form>
    </div>

    <!-- Footer -->
    <footer class="bg-light text-center text-lg-start">
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        &copy; 2023 SHCSMS. All rights reserved.
    </div>
    </footer>
    <?php include('signin.php'); ?>
</body>
</html>