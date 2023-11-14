<?php
    /*******w******** 
    Name: Qiang Yao
    Date: 2023-11-07
    Description: vehicle list page(non-administrative)
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <script language="javascript" src="admin.js"></script>
    <script language="javascript" src="tools/makemodel.js"></script>
    <title>Welcome to SHCSMS</title>
</head>
<body class="green-theme">
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">                
        <a class="navbar-brand" href="#">SHCSMS</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>        
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav  ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="new.php">CreateNew <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="categories.php">Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Logout</a>
                </li>
                <!-- <li class="nav-item">
                    <a id="navAdmin" class="nav-link" href="#" data-toggle="modal" data-target="#loginModal">Sign in</a>
                </li> -->
            </ul>
        </div>
    </nav>

    <div id="container" class="container mt-5">
        <!-- Search Form -->
        <form id="searchForm" class="mb-4">
          <div class="form-row">
              <div class="col">
                  <select class="custom-select" id="makeSelect" name="make">
                      <option value="">Select Make</option>
                  </select>
              </div>
              <div class="col">
                  <select class="custom-select" id="modelSelect" name="model">
                      <option value="">Select Model</option>
                  </select>
              </div>
              <div class="col">
                  <select class="custom-select" id="categorySelect" name="category_id">
                      <option value="">All Categories</option>
                      <?php foreach (CATEGORY_OPTIONS as $coption): ?>
                        <option value="<?= $coption['category_id'] ?>"><?= $coption['category_name'] ?></option>
                      <?php endforeach ?>
                  </select>
              </div>
              <!-- <div class="col">
                  <input type="text" class="form-control" id="priceRange" placeholder="Price Range">
              </div> -->
              <div class="col">
                  <button class="btn btn-primary" type="submit">Show me cars</button>
              </div>
          </div>
      </form>

      <!-- Search Results -->
      <table class="table table-striped table-bordered table-hover" id="searchResults">
        <thead>
            <tr>
                <th id='make'>Make<i class="fas fa-sort"></i></th>
                <th id='model'>Model<i class="fas fa-sort"></i></th>
                <th id='category_name'>Category<i class="fas fa-sort"></i></th>
                <th id='year'>Year<i class="fas fa-sort"></i></th>
                <th id='price'>Price(CA$)<i class="fas fa-sort"></i></th>
                <th id='mileage'>Mileage(km)<i class="fas fa-sort"></i></th>
                <th id='exterior_color'>Color<i class="fas fa-sort"></i></th>
                <th id='create_time'>Create_Time<i class="fas fa-sort"></i></th>
                <th id='update_time'>Update_Time<i class="fas fa-sort"></i></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <!-- Search results will be displayed here -->
        </tbody>
      </table>

      <!-- Pagination -->
      <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
          <li class="page-item">
            <a id="prevPage" class="page-link" href="#" aria-label="Previous">
              <span aria-hidden="true">&laquo; Previous</span>
            </a>
          </li>
          <!-- Dynamic pagination numbers would be inserted here -->
          <li class="page-item disabled">
            <span class="page-link">Page <span id="currentPage">1</span> of <span id="totalPages">1</span></span>
          </li>
          <li class="page-item">
            <a id="nextPage" class="page-link" href="#" aria-label="Next">
              <span aria-hidden="true">Next &raquo;</span>
            </a>
          </li>
        </ul>
      </nav>

      <!-- Footer -->
      <footer class="bg-light text-center text-lg-start">
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            &copy; 2023 SHCSMS. All rights reserved.
        </div>
      </footer>
      <?php include('signin.php'); ?>
</body>
</html>