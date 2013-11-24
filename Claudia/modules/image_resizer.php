<?php

class Image {
	
	private $image= '';
	private $resize_image = '';
	private $thumbnail = '';
	private $orig_width = '';
	private $orig_height = '';
	private $file_ext = '.jpg';
	
	private function create_resize($max_width, $max_height){
		$aspect_ratio = $this->orig_width/$this->orig_height;
		//Portrait
		if($aspect_ratio <= 1)
		{
			$new_height = $max_height;
			$new_width = $new_height * $aspect_ratio;
		}
		//Landscaep
		else
		{
			$new_width = $max_width;
			$new_height = $new_width / $aspect_ratio;
		}
		$this->resize_image = imagecreatetruecolor($new_width, $new_height);
		// dest, source, destX, destY, sourceX, sourceY, destW, destH, sourceW, sourceH
		imagecopyresized($this->resize_image, $this->image,0 ,0 ,0 ,0, $new_width, $new_height, $this->orig_width, $this->orig_height);
	}
	
	private function create_thumbnail($thumb_width, $thumb_height){
		$midX = imagesx($this->resize_image) / 2.0;
		$midY = imagesy($this->resize_image) / 2.0;
		$srcX = $midX - $thumb_width / 2.0;
		$srcY = $midY - $thumb_height / 2.0;
		$this->thumbnail = imagecreatetruecolor($thumb_width, $thumb_height);
		imagecopyresized($this->thumbnail, $this->resize_image, 0, 0, $srcX, $srcY, $thumb_width, $thumb_height, $thumb_width, $thumb_height);
	}
	
	public function save_to_paths($image_path, $thumb_path){
		$date = new DateTime();
		$rnd = rand(1024, 2048);
		$filename = $rnd.'_'.$date->getTimestamp().$this->file_ext;
		$thumbfilename = $rnd.'_'.$date->getTimestamp().'_thumb'.$this->file_ext;
		$filenames = array();
		$filenames[] = $filename;
		$filenames[] = $thumbfilename;
		imagejpeg($this->resize_image, $image_path.'/'.$filename, 100);
		imagejpeg($this->thumbnail, $thumb_path.'/'.$thumbfilename, 90);
		return $filenames;
	}
	
	function __construct($uploaded_image, $type, $max_width = 640, $max_height = 480, $thumb_width = 75, $thumb_height = 75){
		if($type == IMAGETYPE_JPEG){
			$this->image = imagecreatefromjpeg($uploaded_image);
		}else if ($type == IMAGETYPE_PNG){
			$this->image = imagecreatefrompng($uploaded_image);
		}else if ($type == IMAGETYPE_GIF){
			$this->image = imagecreatefromgif($uploaded_image);
		}
		$this->orig_width = imagesx($this->image);
		$this->orig_height = imagesy($this->image);
		$this->create_resize($max_width, $max_height);
		$this->create_thumbnail($thumb_width, $thumb_height);
	}
	
	function __destruct(){
		imagedestroy($image);
		imagedestroy($resize_image);
		imagedestroy($thumbnail);
	}
}
?>