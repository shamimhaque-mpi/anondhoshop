<?php

namespace App\Interfaces; 

interface Model 
{
	public function Model($file);

	public function find(array $condition=[]);

	public function where(array $condition=[]);

	public function orWhere(array $condition=[]);

	public function whereIn($indicator, $refarence=[]);

	public function create(array $data, array $isFileOrSlug=[]);

	public function update(array $data, array $isFileOrSlug=[]);

	public function fileUpload($file, $location);

	public function orderBy($col, $order="asc");

	public function first(array $select=null);

	public function delete(array $file=null);

	public function with(array $models=null);

	public function get(array $select=null);

	public function select($select=[]);

	public function limit($limit);

	public function slug($title);

	public function skip($start);

	public function take($limit);
	
	public function count();

	public function exists();

}
