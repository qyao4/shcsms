<?php
  require 'connect.php';

  // Include Intervention to process images.
  require '../vendor/autoload.php';
  use Intervention\Image\ImageManagerStatic as Image;

  $response = [
    "result" => "fail",
    "message" => "",
    "data" => []
  ];
  
  if(isset($_POST['command']))
  {
    $command = $_POST['command'];
    if($command == 'Create'){
      $sql = "INSERT INTO Vehicles (make,model,year,price,mileage,exterior_color,description,category_id,slug)  
      VALUES (:make,:model,:year,:price,:mileage,:exterior_color,:description,:category_id,:slug)";
      $statement = $db->prepare($sql);
      $statement->bindValue(':make', $_POST['make']);
      $statement->bindValue(':model',$_POST['model']);
      $statement->bindValue(':year',$_POST['year']);
      $statement->bindValue(':price',$_POST['price']);
      $statement->bindValue(':mileage',$_POST['mileage']);
      $statement->bindValue(':exterior_color',$_POST['exterior_color']);
      $statement->bindValue(':description',$_POST['description']);
      $statement->bindValue(':category_id',$_POST['category_id']);
      $statement->bindValue(':slug',str_replace(' ', '-',$_POST['slug']));
      //  Execute the INSERT.
      if($statement->execute()){
        if (isset($_FILES['images']) && $_FILES['images']['error'][0] !== UPLOAD_ERR_NO_FILE ) {
          $uploadedImages = uploadImages($_FILES['images']);
          save_images_to_db($uploadedImages);
        }
        $response["result"] = "succ";
      }
    }
    else if($command == 'Update'){
      //  Execute the UPDATE.
      $fields = ['make','model','year','price','mileage','exterior_color','description','category_id','slug'];
      $update_fields = [];
      $bind_values = [];
      foreach($fields as $field){
        if(isset($_POST[$field])){
          $update_fields[] = "$field = :$field";
          $bind_values[$field] = $field == 'slug' ? str_replace(' ', '-',$_POST[$field]) : $_POST[$field];
        }
      }
      $sql = "UPDATE vehicles SET ". implode(" , ", $update_fields) . " WHERE vehicle_id = :vehicle_id";
      $bind_values['vehicle_id'] = $_POST['vehicle_id'];
      $statement = $db->prepare($sql);
      
      if($statement->execute($bind_values)){
        if (isset($_FILES['images'])  && $_FILES['images']['error'][0] !== UPLOAD_ERR_NO_FILE ) {
          $uploadedImages = uploadImages($_FILES['images']);
          save_images_to_db($uploadedImages);
        }
        delete_images();
        $response["result"] = "succ";
        $response["data"] = ["slug"=>str_replace(' ', '-',$_POST[$field])];
      }
    }
    else if($command == 'Delete'){
      $sql = "DELETE FROM Vehicles WHERE vehicle_id = :vehicle_id";
      $statement = $db->prepare($sql);
      $statement->bindValue(':vehicle_id',$_POST['vehicle_id']);
      //  Execute the DELETE.
      if($statement->execute()){
        $response["result"] = "succ";
      }
    }
    else{
      $response['message'] = 'wrong command.';
    }
  }
  $jsonData = json_encode($response);
  header('Content-Type: application/json');
  echo $jsonData; 

  function uploadImages($images) {
    $uploadPath = __DIR__ . '/../public/uploads/';
    if (!file_exists($uploadPath)) {
        mkdir($uploadPath, 0777, true);
    }
    $uploadedImages = [];
    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/webp'];

    for ($i = 0; $i < count($images['name']); $i++) {
        $tmpFilePath = $images['tmp_name'][$i];
        $fileMimeType = mime_content_type($tmpFilePath);

        if (in_array($fileMimeType, $allowedMimeTypes) && $tmpFilePath != "") {
          $fileExtension = pathinfo($images['name'][$i], PATHINFO_EXTENSION);
          $baseFileName = uniqid();

          // original
          $originalFileName = $baseFileName . '_original.' . $fileExtension;
          $originalFilePath = $uploadPath . $originalFileName;
          Image::make($tmpFilePath)->save($originalFilePath);

          // medium（400）
          $mediumFileName = $baseFileName . '_medium.' . $fileExtension;
          $mediumFilePath = $uploadPath . $mediumFileName;
          Image::make($tmpFilePath)->resize(400, null, function ($constraint) {
              $constraint->aspectRatio();
          })->save($mediumFilePath);

          // thumb（50）
          $thumbFileName = $baseFileName . '_thumb.' . $fileExtension;
          $thumbFilePath = $uploadPath . $thumbFileName;
          Image::make($tmpFilePath)->resize(150, null, function ($constraint) {
              $constraint->aspectRatio();
          })->save($thumbFilePath);

          $uploadedImages[] = ['filename' => $originalFileName, 'filenameMedium' => $mediumFileName, 'filenameThumb'=>$thumbFileName];
        }
    }

    return $uploadedImages;
  }

  function save_images_to_db($uploadedImages){
    global $db;
    $lastInsertId = isset($_POST['vehicle_id']) && !empty($_POST['vehicle_id']) ? $_POST['vehicle_id'] : $db->lastInsertId();

    foreach ($uploadedImages as $image) {
        $sql = "INSERT INTO VehicleImages (vehicle_id, filename, filenameMedium, filenameThumb) 
                VALUES (:vehicle_id, :filename, :filenameMedium, :filenameThumb)";
        $statement = $db->prepare($sql);
        $statement->bindValue(':vehicle_id', $lastInsertId);
        $statement->bindValue(':filename', $image['filename']);
        $statement->bindValue(':filenameMedium', $image['filenameMedium']);
        $statement->bindValue(':filenameThumb', $image['filenameThumb']);
        $statement->execute();
    }
  }

  function delete_images(){
    global $db;
    if (isset($_POST['deleteImageIds']) && count($_POST['deleteImageIds'])>0){
      $del_images = $_POST['deleteImageIds'];
      foreach($del_images as $image_id){
        $sql = "DELETE FROM VehicleImages WHERE image_id = :image_id";
        $statement = $db->prepare($sql);
        $statement->bindValue(':image_id', $image_id);
        $statement->execute();
      }
    }
  }
?>