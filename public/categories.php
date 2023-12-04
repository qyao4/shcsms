<?php
    /*******w******** 
    Name: Qiang Yao
    Date: 2023-11-13
    Description: Update vehicle Categories (administrative)
    ****************/
    // Authenticate
    $need_authenticated = true; 
    require('authenticate.php');

    $links = [
        "home"=>'admin.php',
    ];

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
    <script src="categories.js"></script>
    <title>Welcome to SHCSMS</title>
    <style>
        
    </style>
</head>
<body class="green-theme">
    <!-- Header -->
    <?php include('header.php'); ?>

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
                            <td><input type='text' class='form-control' data-edit_type='update'
                                name='<?= htmlspecialchars($category['category_id']) ?>' 
                                data-org_value='<?= htmlspecialchars($category['category_name']) ?>'
                                value='<?= htmlspecialchars($category['category_name']) ?>'></td>
                            <td></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="form-group text-right">
                <button type="button" class="btn btn-primary" id="addRow">Add New Category</button>
                <button type="submit" class="btn btn-success">Save Changes</button>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <?php include('footer.php'); ?>
    <?php include('signin.php'); ?>
</body>
</html>