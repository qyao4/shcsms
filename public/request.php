<?php
  // $message = "Hello SHCSMS!";
  // require __DIR__ . '/../src/connect.php';

  // $sql = "SELECT v.make, v.model, vc.category_name, v.year, v.price, v.mileage, v.exterior_color, v.vehicle_id 
  //         FROM vehicles v 
  //         INNER JOIN vehiclecategories vc ON vc.category_id = v.category_id";
  // $statement = $db->prepare($sql);
  // $statement->execute();
  // while($row = $statement->fetch()){
  //   print_r($row);
  // }

  // public/index.php
  if (isset($_POST['action']) && $_POST['action'] === 'search') {
    require __DIR__ . '/../src/search.php';
  }
  if(isset($_POST['action']) && $_POST['action'] === 'process'){
    require __DIR__ . '/../src/process.php';
  }
  if(isset($_POST['action']) && $_POST['action'] === 'getVehicle'){
    require __DIR__ . '/../src/getVehicle.php';
  }

?>