<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="A simple website to show your support for Ukraine">
    <meta name="tags" content="Ukraine, Slava Ukraini, Russia, Support Ukraine, Ukraineify">
    <title>Ukraineify.me</title>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');
        @import url(style.css);
        .finalimage {
            max-height: 400px;
            min-height: 200px;
            max-width: 400px;
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
            border-radius: 3px;
        }
    </style>
  
</head>
    <body>
        <div class="header">
            <h1><span style="color: #0057b7;">Ukraineify</span><span style="color: #ffd700;">.me</span></h1>
            <p class="description">Millions across the world have expressed their support for Ukraine's fight against the Russian invasion. Use this tool to join the thousands of others who have updated their profile pictures to show their support for Ukraine.</p>
             

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


$width = .35 * $imgwidth;
$height = .35 * $imgheight;

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


$width = .35 * $imgwidth;
$height = .35 * $imgheight;

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
          echo "<img class='finalimage' src=https://ukraineify.me/photos/watermarked/$photonamegen"."watermarked.jpg>";
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
                  
                  
        </div>

    </body>
</html>
