<?php

include 'dbconnect.php';

session_start();

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["inputImage"]["name"]);
$uploadOk = 1;
$imageFileName = "";
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


if (!isset($_SESSION['loggedin'])){

  header("Location: /PHP/tic-tac-toe/index.php");
  exit;

}else{

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["inputImage"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["inputImage"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["inputImage"]["tmp_name"], $target_file)) {

    $imageFileName = htmlspecialchars( basename( $_FILES["inputImage"]["name"]));

    //create image path /backend/uploads
    $imagePath = "backend/uploads/" . $imageFileName;

    //add image to database
    $sql = "UPDATE sign_up SET imagePath = '$imagePath' WHERE username = '" . $_SESSION['username'] . "'";
    $result = mysqli_query($conn, $sql);
    header("Location: /PHP/tic-tac-toe/welcome.php");
    echo "<script>alert('Image uploaded successfully.');</script>";
  } else {
    echo "Sorry, there was an error uploading your file.";
    }
  }
}
?>