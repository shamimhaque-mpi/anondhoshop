<?php

namespace App\Interfaces;

interface Admin 
{
	public function image($file);
	public function get();
	public function update($data);
}