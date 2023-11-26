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

    $links = [
        "logout"=>isset($_SESSION['user_logged_in']),
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/luminous-lightbox/2.0.1/luminous-basic.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/luminous-lightbox/2.0.1/Luminous.min.js"></script>
    <title>Welcome to SHCSMS</title>
    <style>
        #carouselControls {
        max-width: 400px; 
        margin: auto;
}
    </style>
</head>
<body>
    <!-- Header -->
    <?php include('header.php'); ?>

    <div id="container" class="container mt-5">
        <!-- image area -->
        <div class="row mb-4">
            <div id="carouselControls" class="carousel slide" data-ride="carousel" style="display: none";>
                <div class="carousel-inner" id="carouselImages">
                    <!-- images here -->
                </div>
                <a class="carousel-control-prev" href="#carouselControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
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
    <?php include('footer.php'); ?>
    <?php include('signin.php'); ?>
    <script language="javascript" src="view.js"></script>
</body>
</html>