<?php

    $currentDirectory = getcwd();
    $uploadDirectory = "/photos/original/";
    $errors = []; // Store errors here
    $fileExtensionsAllowed = ['jpeg','jpg','png']; // These will be the only file extensions allowed 
    $fileName = $_FILES['the_file']['name'];
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
    $fileSize = $_FILES['the_file']['size'];
    $fileTmpName  = $_FILES['the_file']['tmp_name'];
    $fileType = $_FILES['the_file']['type'];
    $fileExtension = strtolower(end(explode('.',$fileName)));
    $namelength = 9;
    $photonamegen = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$namelength);
    $uploadPath = $currentDirectory . $uploadDirectory . $photonamegen . "." . $ext; 
    

    if (isset($_POST['submit'])) {

      if (! in_array($fileExtension,$fileExtensionsAllowed)) {
        $errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
      }

      if ($fileSize > 4000000) {
        $errors[] = "File exceeds maximum size (4MB)";
      }

      if (empty($errors)) {
        $didUpload = move_uploaded_file($fileTmpName, $uploadPath);
        $sourceS = "photos/original/$photonamegen.$ext"; // SOURCE IMAGE
$sourceW = "photos/flag.png"; // WATERMARK IMAGE
$target = "photos/watermarked/$photonamegen"."watermarked.jpg"; // WATERMARKED IMAGE
$quality = 100; // WATERMARKED IMAGE QUALITY (0 to 100)
$posX = 0; // PLACE WATERMARK AT LEFT CORNER
$posY = 0; // PLACE WATERMARK AT TOP CORNER

if ($ext = "png") {
   $imgS = imagecreatefrompng($sourceS);
$imgW = imagecreatefrompng($sourceW); 
}
elseif ($ext = "jpeg") {
   $imgS = imagecreatefromjpeg($sourceS);
$imgW = imagecreatefrompng($sourceW); 
}



imagecopy(
  $imgS, $imgW, // COPY WATERMARK ONTO SOURCE IMAGE
  $posX, $posY, // PLACE WATERMARK AT TOP LEFT CORNER
  0, 0, imagesx($imgW), imagesY($imgW) // COPY FULL WATERMARK IMAGE WITHOUT CLIPPING
);

// (D) OUTPUT
imagejpeg($imgS, $target, $quality);

        if ($didUpload) {
          echo "The file " . basename($fileName) . " has been uploaded";
          echo "<img src=https://ukraineify.me/photos/watermarked/$photonamegen"."watermarked.jpg>";
        } else {
          echo "An error occurred. Please contact the administrator.";
        }
      } else {
        foreach ($errors as $error) {
          echo $error . "These are the errors" . "\n";
        }
      }

    }
    
?>
