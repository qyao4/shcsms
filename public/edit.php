<?php
    /*******w******** 
    Name: Qiang Yao
    Date: 2023-11-07
    Description: Create new vehicle (administrative)
    ****************/
    $baseURL = "http://" . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . "/";

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
    <base href="<?php echo $baseURL; ?>">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
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

        /* comments css*/
        .comment-container {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .comment-content {
            background-color: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .comment-actions {
            text-align: right;
        }

        .comment-actions button {
            margin-left: 5px;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .comment-actions button:hover {
            background-color: #0056b3;
        }
        /* comments css*/

        /* image css */
        .image-preview {
            position: relative;
            display: inline-block;
            margin: 10px;
        }

        .image-preview img {
            width: 150px; 
            height: auto;
            border-radius: 5px;
        }

        .delete-btn {
            position: absolute;
            top: 0;
            right: 0;
            border: none;
            background-color: red;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        .delete-btn:hover {
            background-color: darkred;
        }
        /* image css */
    </style>
</head>
<body class="green-theme">
    <!-- Header -->
    <?php include('header.php'); ?>

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
                <form id="VehicleForm" class="mt-3"  enctype="multipart/form-data">
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
                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" placeholder="Enter a slug for permalink" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="images">Upload Images</label>
                        <input type="file" class="form-control" id="images" name="images[]" multiple>
                    </div>
                    <div id="imagePreviewContainer" class="image-preview-container">
                        <!-- Dynamically loaded images will be displayed here -->
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary" id="Update">Update</button>
                        <button type="submit" class="btn btn-primary" id="Delete">Delete</button>
                    </div>
                </form>
            </div>

            <!-- Comments Info Tab -->
            <div class="tab-pane fade" id="comments-info" role="tabpanel" aria-labelledby="comments-info-tab">
                <div class="mt-3" id="commentsContainer">
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include('footer.php'); ?>
    <?php include('signin.php'); ?>
    <script language="javascript" src="edit.js"></script>
</body>
</html>