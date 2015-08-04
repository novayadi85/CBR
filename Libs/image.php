<?php
class Image {
 
   var $image;
   var $image_type;
   public $_sDestination;
   public $xml_type = array('xml');
   public $type = array('doc,docx,txt,pdf,jpg,png,gif');
   public $max_size = 2000;
   
   private function __getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
	}
   
   public function upload($filename,$destination,$tmp_file){
			$this->_sDestination = $this->_buildDir($destination);
			$destination = $this->_sDestination . $filename;
			$upload = copy($tmp_file,$destination);
			return $destination;
   }
   
   public function filePath($path){
		return $return = str_replace(FILE_DIR,'',$path);
   }
   
   private function _buildDir($sDestination)
	{
		
			$aParts = explode('/',date('Y/m'));
			//print_r($aParts);
			$this->_sDestination = $sDestination;
			foreach ($aParts as $sPart)
			{
				$sDate = date($sPart).'/';
				$sDestination .= $sDate;
				
				if (!is_dir($sDestination))
				{
					@mkdir($sDestination, 0777);
					@chmod($sDestination, 0777);
				}
			}
			
		//$this->_sDestination = $sDestination;
		return $sDestination;
	}
 
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
   function save($filename, $image_type=IMAGETYPE_JPEG, $compression=80, $permissions=null) {
 
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
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;
   }      
   
   function rename($old,$new){
       $filename = rename($old,$new);
       return $filename;
   }
 
}
?>