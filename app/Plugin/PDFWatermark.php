<?php

namespace App\Plugin;

class PDFWatermark {
 
	private $_file;
	private $_height;
	private $_width;
 
	function __construct($file) {
 
		$this->_file = $this->_prepareImage($file);
		$this->_getImageSize( $this->_file );
	}
	
	private function _prepareImage($file) {
		
		$imagetype = exif_imagetype( $file );
		$path =  sys_get_temp_dir() . '/' . uniqid() . '.png';
		
		switch( $imagetype ) {
			
			case IMAGETYPE_JPEG: 
				$image = imagecreatefromjpeg($file);
				imageinterlace($image,false);
				imagejpeg($image, $path);
				imagedestroy($image);
				break;
				
			case IMAGETYPE_PNG:
				$image = imagecreatefrompng($file);
				imageinterlace($image,false);
				imagesavealpha($image,true);
				imagepng($image, $path);
				imagedestroy($image);
				break;
			default:
				throw new Exception("Unsupported image type");
				break;
		};
		
		return $path;
		
	}
	
	private function _getImageSize($image) {
		$is = getimagesize($image);
		$this->_width = $is[0];
		$this->_height = $is[1];
	}
	
	public function getFilePath() {
		return $this->_file;
	}
	
	public function getHeight() {
		return $this->_height;
	}
	
	public function getWidth() {
		return $this->_width;
	}
}