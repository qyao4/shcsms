<?php
  $message = "Hello SHCSMS!";
  require __DIR__ . '/../src/connect.php';

  $sql = "SELECT v.make, v.model, vc.category_name, v.year, v.price, v.mileage, v.exterior_color, v.vehicle_id 
          FROM vehicles v 
          INNER JOIN vehiclecategories vc ON vc.category_id = v.category_id";
  $statement = $db->prepare($sql);
  $statement->execute();
  while($row = $statement->fetch()){
    print_r($row);
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Welcome to SHCSMS</title>
</head>
<body>
    <div id="container">
        <p><?= $message ?></p>
        <button class="btn btn-primary" name="command" value="Click me">Click me</button>
    </div>
</body>
</html>