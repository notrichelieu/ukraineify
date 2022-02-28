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
    $file_name_array = explode('.',$fileName);
    $fileExtension=strtolower(end($file_name_array));
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



if ($ext == "png") {
   $imgS = imagecreatefrompng($sourceS);
$imgW = imagecreatefrompng($sourceW);

$imgwidth = imagesx($imgS);
$imgheight = imagesy($imgS);


$width = .2 * $imgwidth;
$height = .2 * $imgheight;

// Get new dimensions
list($width_orig, $height_orig) = getimagesize($sourceW);

$ratio_orig = $width_orig/$height_orig;

if ($width/$height > $ratio_orig) {
   $width = $height*$ratio_orig;
} else {
   $height = $width/$ratio_orig;
}




}
elseif ($ext == "jpeg" || $ext == "jpg") {
   $imgS = imagecreatefromjpeg($sourceS);
$imgW = imagecreatefrompng($sourceW); 

$imgwidth = imagesx($imgS);
$imgheight = imagesy($imgS);


$width = .2 * $imgwidth;
$height = .2 * $imgheight;

// Get new dimensions
list($width_orig, $height_orig) = getimagesize($sourceW);

$ratio_orig = $width_orig/$height_orig;

if ($width/$height > $ratio_orig) {
   $width = $height*$ratio_orig;
} else {
   $height = $width/$ratio_orig;
}

}




imagecopyresampled($imgS, $imgW, $posX, $posY, 0, 0, $width, $height, imagesx($imgW), imagesy($imgW));

// (D) OUTPUT
imagejpeg($imgS, $target, $quality);

        if ($imgW) {
          echo "The file " . basename($fileName) . " has been uploaded";
          echo "<img height='50%' src=https://ukraineify.me/photos/watermarked/$photonamegen"."watermarked.jpg>";
          echo $imgwidth;
          echo $imgheight;
          echo $width;
          echo $height;
          echo $width_orig;
          echo $height_orig;
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
