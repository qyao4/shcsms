<?php
    /*******w******** 
    
    Name: Qiang Yao
    Date: 2023-11-07
    Description: view and comment vehicle details(non-administrative)

    ****************/
    $baseURL = "http://" . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . "/";

    $need_authenticated = false; //non-administrative
    
    if (session_status() == PHP_SESSION_NONE)
        session_start();

    // if (isset($_SESSION['user_logged_in']) )
    //     unset($_SESSION['user_logged_in']); 

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
    <!-- <script language="javascript" src="tools/makemodel.js"></script> -->
    <title>Welcome to SHCSMS</title>
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="index.php">SHCSMS</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>        
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <!-- <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pricing</a>
                </li> -->
                <li class="nav-item">
                    <a id="navAdmin" class="nav-link" href="#" data-toggle="modal" data-target="#loginModal">Sign in</a>
                </li>
            </ul>
        </div>
    </nav>

    <div id="container" class="container mt-5">
        <!-- image area -->
        <div class="row mb-4">
            <div class="col">
                <!-- images -->
                <img src="placeholder.jpg" alt="Vehicle Image" class="img-fluid">
            </div>
        </div>

        <!-- vehicle base info -->
        <div class="row mb-2">
            <div class="col">
                <p style="color: red;"><strong>Price:</strong> $<span id="price"></span> CAD</p>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-4">
                <p><strong>Make:</strong> <span id="make"></span></p>
            </div>
            <div class="col-md-4">
                <p><strong>Model:</strong> <span id="model"></span></p>
            </div>
            <div class="col-md-4">
                <p><strong>Category:</strong> <span id="category_name"></span></p>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-4">
                <p><strong>Exterior Color:</strong> <span id="exterior_color"></span></p>
            </div>
            <div class="col-md-4">
                <p><strong>Mileage:</strong> <span id="mileage"></span> km</p>
            </div>
            <div class="col-md-4">
                <p><strong>Year:</strong> <span id="year"></span></p>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col">
                <p><strong>Description:</strong><span id="description"></span></p>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col text-right">
                <p style="color: gray; font-style: italic;">Posted on: <span id="create_time"></span></p>
            </div>
        </div>

        <!-- comments -->
        <div class="row">
            <div class="col-12 col-md-12">
                <h3>Comments</h3>
                <!-- histtory -->
                <div id="comments">
                    <!-- content -->
                </div>
            </div>
            <div class="col-12 col-md-12">
                <form id="commerntForm">
                    <fieldset>
                    <legend>Leave Your Comment</legend>
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="contentText">Comment:</label>
                            <textarea class="form-control" id="contentText" name="content" rows="3" required></textarea>
                        </div>
                        <!-- <img src="tools/captcha_script.php" alt="CAPTCHA">
                        <button type="submit" class="btn btn-primary">Submit Comment</button> -->
                        <div class="form-group row justify-content-end">
                            <div class="col-auto">
                                <img src="tools/captcha_script.php" alt="CAPTCHA" class="mb-3">
                            </div>
                            <div class="col-auto">
                                <input type="text" name="captcha" class="form-control" placeholder="Enter CAPTCHA" required>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">Submit Comment</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
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
    <script language="javascript" src="view.js"></script>
</body>
</html>