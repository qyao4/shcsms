<?php
    /*******w******** 
    Name: Qiang Yao
    Date: 2023-11-07
    Description: Create new vehicle (administrative)
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
    <script language="javascript" src="tools/makemodel.js"></script>
    
    
    <title>Welcome to SHCSMS</title>
    <style>
        /* tabs css */
        .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
        color: #495057;
        background-color: #f8f9fa;
        border-color: #dee2e6 #dee2e6 #fff;
        }

        .nav-link {
        color: #007bff;
        background-color: #e9ecef;
        border: 1px solid transparent;
        border-top-left-radius: .25rem;
        border-top-right-radius: .25rem;
        }

        .nav-link:hover {
        border-color: #e9ecef #e9ecef #dee2e6;
        }

        .tab-content {
        border: 1px solid #dee2e6;
        padding: 20px;
        border-top: none;
        }
        /* tabs css */
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
        <!-- Tab navigation -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="vehicle-info-tab" data-toggle="tab" href="#vehicle-info" role="tab" aria-controls="vehicle-info" aria-selected="true">Vehicle Info</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="comments-info-tab" data-toggle="tab" href="#comments-info" role="tab" aria-controls="comments-info" aria-selected="false">Comments Info</a>
            </li>
        </ul>

        <!-- Tab content -->
        <div class="tab-content" id="myTabContent">
            <!-- Vehicle Info Tab -->
            <div class="tab-pane fade show active" id="vehicle-info" role="tabpanel" aria-labelledby="vehicle-info-tab">
                <form id="VehicleForm" class="mt-3">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="makeSelect">Make</label>
                            <select class="custom-select" id="makeSelect" name="make" required>
                                <option value="">Select Make</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="modelSelect">Model</label>
                            <select class="custom-select" id="modelSelect" name="model" required>
                                <option value="">Select Model</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="category">Category</label>
                            <select class="form-control" id="category" name="category_id" required>
                                <option value="">Select a Category</option>
                                <?php foreach (CATEGORY_OPTIONS as $coption): ?>
                                    <option value="<?= $coption['category_id'] ?>"><?= $coption['category_name'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="year">Year</label>
                            <input type="number" class="form-control" id="year" name="year" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="price">Price</label>
                            <input type="text" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="mileage">Mileage</label>
                            <input type="text" class="form-control" id="mileage" name="mileage" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="exteriorColor">Exterior Color</label>
                            <input type="text" class="form-control" id="exteriorColor" name="exterior_color" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" id="Update">Update</button>
                    <button type="submit" class="btn btn-primary" id="Delete">Delete</button>
                </form>
            </div>

            <!-- Comments Info Tab -->
            <div class="tab-pane fade" id="comments-info" role="tabpanel" aria-labelledby="comments-info-tab">
                <div class="mt-3">
                    <p>In building...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-light text-center text-lg-start">
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        &copy; 2023 SHCSMS. All rights reserved.
    </div>
    </footer>
    <?php include('signin.php'); ?>
    <script language="javascript" src="edit.js"></script>
</body>
</html>