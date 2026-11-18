<?php

namespace App\Controller\Component;

use Cake\Controller\Component;

class ImageComponent extends Component
{

   var $image;
   var $image_type;
   var $location;

   function load($filename) {
      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
      if( $this->image_type == IMAGETYPE_JPEG ) {
         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {
         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {
         $this->image = imagecreatefrompng($filename);
      }
   }



   function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image,$filename,$compression);
      } elseif( $image_type == IMAGETYPE_GIF ) {

         imagegif($this->image,$filename);
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image,$filename);
      }
      if( $permissions != null) {
         chmod($filename,$permissions);
      }
   }

   function output($image_type=IMAGETYPE_JPEG) {
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image);
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image);
      }
   }
   function getWidth() {
      return imagesx($this->image);
   }
   function getHeight() {
      return imagesy($this->image);
   }
   function resizeToHeight($height) {
      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
   }
   function resizeToWidth($width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
   }
   function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100;
      $this->resize($width,$height);
   }
   function resize($width,$height) {
      $new_image = imagecreatetruecolor($width, $height);
      $color = imagecolorallocatealpha($new_image, 255, 255, 255, 127);
      imagefill($new_image, 0, 0, $color);
      imagesavealpha($new_image, TRUE);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;
   }

//// own stuff added 14/06/2010

function getType($filetype) {
   if( $filetype == 'image/jpg' ) {
      $ext = 'jpg';
   } elseif( $filetype == 'image/jpeg' ) {
      $ext = 'jpg';
   } elseif( $filetype == 'image/gif'  ) {
      $ext = 'gif';
   } elseif( $filetype == 'image/png' ) {
      $ext = 'png';
   } elseif( $filetype == 'application/pdf' ) {
      $ext = 'pdf';
   }
   return $ext;
}



   function randomise(){

 	// Get a random set of 3 chars which we will append to the filename to prevent duplicate file names.
	$keychars = "abcdefghijklmnopqrstuvwxyz0123456789";
	$length = 3;
	$randkey = "";
	for ($i=0;$i<$length;$i++)  $randkey .= substr($keychars, rand(1, strlen($keychars) ), 1);

	// Set the name of the file  (current time + the random value + . + the file extension)
	$filename = time().$randkey;

	return $filename;

  //another way $filename = time() . "_" . rand(000000, 999999);

   }


   function uploadimage($location, $upload) {

	   $ext = $this->getType($upload->getClientMediaType());
	   $newfilename = $this->randomise();

			if($ext <> ""){

        $file = $newfilename.".".$ext;
				$uploadfile = $location.$file;

    				if (move_uploaded_file($upload->getStream()->getMetadata('uri'), $uploadfile)){
    				    return $file;
    				}
		    }

    }
}
?>
