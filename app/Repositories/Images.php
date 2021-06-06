<?php

namespace App\Repositories;
use App\Interfaces\Image;

class Images implements Image
{
	

	private $file, $width, $height, $old_width, $old_height, $type, $attr;

	
	/*
	* ===========================
	*	Main Dir
	* ========================
	*/
	public function image($file)
	{
		$this->file = $file;

		list($width, $height, $type, $attr) = getimagesize($file);

		$this->old_width	= $width;
		$this->old_height	= $height;

		$this->width		= $width;
		$this->height		= $height;

		$this->type			= $type;
		$this->attr			= $attr;
		return $this;
	}

	/*
	* ===========================
	*	Image Resize Method
	* ========================
	*/
	public function resize($width, $height=null)
	{
		if($height == null){
			$this->height = (($this->height/$this->width)*$width);
			$this->width = $width;
		}
		else if($width != null && $width > 0){
			$this->width	= $width;
			$this->height	= $height;
		}
		return $this;
	}

	
	/*
	* ===========================
	*	Image Save in location
	* ========================
	*/
	public function save($location, $name, $quality=80) 
	{
		$img = imagecreatefromstring(file_get_contents($this->file));
		// return $width;

		if($img && file_exists($location)){
			// calculate image ratio start----------------
			// list($new_width, $new_height) = $this->image_ratio($prev_width, $prev_height, $new_width);
			// calculate image ratio end------------------

			$trueColor = imagecreatetruecolor($this->width, $this->height);


			// Set the background color of image using 
			// imagecolorallocate() function. 
			$bg = imagecolorallocate($trueColor, 255, 255, 255);


			// Fill background with above selected color.
			imagefill($trueColor, 0, 0, $bg);

			// dd($this->width, $this->height, $this->old_width, $this->old_height);
			// copy image to this 
			imagecopyresampled($trueColor, $img, 0, 0, 0, 0, $this->width, $this->height, $this->old_width, $this->old_height);

			//Image real Path
			$real_path = trim($location, '/')."/".$name.".webp";

			// now create a webp formated imge to specific location
			imagewebp($trueColor, $real_path, $quality);

			// free memory
			imagedestroy($trueColor); 

			return $real_path;
		}
		else{
			return false;
		}

	}

	/*
	* ========================
	*	Delete Exist File 
	*	and image
	* =====================
	*/

	public function delete($dir){
		if(file_exists($dir)){
			unlink($dir);
			return true;
		}else{
			return false;
		}
	}
}