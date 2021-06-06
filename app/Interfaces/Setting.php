<?php
namespace App\Interfaces;

interface Setting {
	/*
	* =======================
	*  This Method Use Only
	*  HTTP Request
	*  On Post
	* =================
	*/
	public function createOrUpdate($request);
	/*
	* =======================
	*  This Method Use Only
	*  HTTP Request
	*  On Post
	* =================
	*/
	public function get();
}