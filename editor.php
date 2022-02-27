<?php
// We need to figure out how we are databasing images, could also just say fuck it and ditch php, make the action client side with JS, though thatd be a pain in the ass, but it might be better in the long run


// PSUEDO

// accept user supplied image using post or get, not sure which yet

//Accept file from page using POST/GET.

//Do standard verification on the uploaded files (File size, resolution, file type) 

// Store file to server using a random name (Ex. I9EKQ4.png)

// Manipulate image using imagecopymerge function to overlay a ukrainian flag into a corner of the image

// Store manipualted image to server

// Output image on page

// Destroy both images after set period of time (Probably wont be in this code, but rather in a cron job that can use a database of a list of recently uploaded images.)
// This problem could be avoided by just destroying the image after the user exits the page, like maybe store it in a cache with like mongo or something and just clear it whenever the user exits the page, though it might be difficult to deal with users wanting to return to the page


// Some ideas: 
// https://github.com/ajaxray/php-watermark
// https://phpimageworkshop.com/tutorial/1/adding-watermark.html
// https://phppot.com/php/php-watermark/

// Here is an example i found on the php site; it is made for applying watermarks



// Load the stamp and the photo to apply the watermark to
$stamp = imagecreatefrompng('stamp.png');
$im = imagecreatefromjpeg('photo.jpeg');

// Set the margins for the stamp and get the height/width of the stamp image
$marge_right = 10;
$marge_bottom = 10;
$sx = imagesx($stamp);
$sy = imagesy($stamp);

// Copy the stamp image onto our photo using the margin offsets and the photo 
// width to calculate positioning of the stamp. 
imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));

// Output and free memory
header('Content-type: image/png');
imagepng($im);
imagedestroy($im);






?>