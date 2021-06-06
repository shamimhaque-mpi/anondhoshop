<?php
namespace App\Interfaces;

interface Image{

	public function image($file);

	public function resize($width, $height=null);

	public function save($location, $name, $quality=80); 

	public function delete($file);
}