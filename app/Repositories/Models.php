<?php
namespace App\Repositories;
use App\Interfaces\Model;
use App\Repositories\Images;
/**
 * 
 */
class Models implements Model
{
	protected $model, $id=null, $width=null, $height=null, $quality=null;

	public function __construct($model=null)
	{	
		if($model){
			$this->model = "\App\Models\\".$model;	
			$this->model = new $this->model;
		}
	}

	/*
	 * ====================
	 * 	Find The Model
	 * =================
	*/
	public function model($model=null)
	{
		if($model){
			$this->model = "\App\Models\\".$model;	
			$this->model = new $this->model;
		}
		return $this;
	}

	/*
	 * ===============
	 * 	Find Data
	 * =============
	*/
	public function find(array $condition=[])
	{
		$this->model = $this->model->where($condition);
		return $this;
	}
	public function where(array $condition=[])
	{
		$this->model = $this->model->where($condition);
		return $this;
	}
	public function orWhere(array $condition=[])
	{
		$this->model = $this->model->orWhere($condition);
		return $this;
	}
	public function whereIn($indicator, $refarence=[])
	{
		$this->model = $this->model->whereIn($indicator, $refarence);
		return $this;
	}

	/*
	 * =========================
	 * 	Agerload
	 * ======================
	*/
	public function with(array $models=null)
	{
		if(count($models) > 0){
			$this->model = $this->model->with($models);			
		}
		return $this;
	}

	/*
	 * =========================
	 * 	Order by file Name
	 * ======================
	*/
	public function orderBy($col, $order="asc") 
	{
		$this->model = $this->model->orderBy($col, $order);
		return $this;
	}

	/*
	 * =========================
	 * 	Select Colum by colum
	 * =======================
	*/
	public function select($select=[]) 
	{
		$this->model = $this->model->select($select);
		return $this;
	}

	/*
	 * =========================
	 * 	Get Data from Model
	 * ======================
	*/
	public function get(array $select=null)
	{
		if($select){
			return $this->model->get($select);			
		}else{
			return $this->model->get();						
		}
	}

	/*
	 * =========================
	 * 	Get Data from Model
	 * ======================
	*/
	public function exists()
	{
		return $this->model->exists();		
	}

	/*
	 * =========================
	 * 	Get Data from Model
	 * ======================
	*/
	public function first(array $select=null)
	{
		if($select){
			return $this->model->first($select);			
		}else{
			return $this->model->first();						
		}
	}

	/*
	 * =========================
	 * 	Create New Data
	 * ======================
	*/
	public function create(array $data, array $isFileOrSlug=[])
	{	
		$file = true;
		foreach ($isFileOrSlug as $key => $value) 
		{
			if($key == 'file' && isset($data[$value]))
			{
				$location 	= (isset($isFileOrSlug['location']) ? $isFileOrSlug['location'] : null);
				if(isset($isFileOrSlug['size']))
				{
					$this->width   = ($isFileOrSlug['size'][0] ?? null);
					$this->height  = ($isFileOrSlug['size'][1] ?? null);
					$this->quality = ($isFileOrSlug['quality'] ?? null);

					$file = $data[$value] = $this->fileUpload($data[$value], $location);
				}
				else{
					$file = $data[$value] = $this->fileUpload($data[$value], $location);
				}
			}
			if($key == 'slug'){
				$data['slug'] = $this->slug($data[$value]); 
			}
		}
		if($file)
		{
			return $this->model->create($data);
		}
		return false;
	}

	/*
	 * =========================
	 * 	Update Model Data
	 * ======================
	*/
	public function update(array $data, array $isFileOrSlug=[])
	{	
		$file = true;
		if(isset($isFileOrSlug['file']) && isset($data[$isFileOrSlug['file']]))
		{
			$location = (isset($isFileOrSlug['location']) ? $isFileOrSlug['location'] : null);
			if(isset($isFileOrSlug['size']))
			{
				$this->width   = ($isFileOrSlug['size'][0] ?? null);
				$this->height  = ($isFileOrSlug['size'][1] ?? null);
				$this->quality = ($isFileOrSlug['quality'] ?? null);

				$file = $data[$isFileOrSlug['file']] = $this->fileUpload($data[$isFileOrSlug['file']], $location);
				if($file && file_exists($this->model->first()->{$isFileOrSlug['file']})){
					unlink($this->model->first()->{$isFileOrSlug['file']});
				}
			}
			else{
				$file = $data[$isFileOrSlug['file']] = $this->fileUpload($data[$isFileOrSlug['file']], $location);
				if($file && file_exists($this->model->first()->{$isFileOrSlug['file']})){
					unlink($this->model->first()->{$isFileOrSlug['file']});
				}
			}
		}
		if($file)
		{
			$this->id = $this->model->first()->id;
			$this->model->update($data);
			return $this->id;
		}
		return false;
	}

	/*
	 * =========================
	 * 	File Uploading
	 * ======================
	*/
	public function fileUpload($file, $location)
	{
		$width = $this->width ?? 300;
		$height= $this->height ?? '';

		$image = new Images;
		return $image->image($file)->resize($width, $height)->save($location, time(), ($this->quality ?? 30));
	}

	/*
	 * =========================
	 * 	Slug Generate
	 * ======================
	*/
	public function slug($title)
	{
		$new_slug = str_replace(' ', '_', $title);
		while($this->model::where('slug', $new_slug)->first()){
			$new_slug = $new_slug.'_'.rand(000000, 999999);
		}
		return $new_slug;
	}

	/*
	 * =========================
	 * 	Set Limit
	 * ======================
	*/
	public function limit($limit)
	{
		$this->model->limit($limit);
		return $this;
	}

	/*
	 * =========================
	 * 	Starting Limit
	 * ======================
	*/
	public function skip($start)
	{
		$this->model->skip($start);
		return $this;
	}

	/*
	 * =========================
	 * 	And Data Count
	 * ======================
	*/
	public function take($limit)
	{
		return $this->model->take($limit);
	}

	/*
	 * =========================
	 * 	Count Total Data
	 * ======================
	*/
	public function count()
	{
		return $this->model->count();
	}

	/*
	 * ===========================
	 * 	Delete Data from Model
	 * ==========================
	*/
	public function delete(array $file=null)
	{
		if($this->model->first()){
			if(isset($file['file']))
			{
				$file = $this->model->first($file['file'])->toArray()[$file['file']];
				if(file_exists($file)){
					unlink($file);
				}
			}
		}
		$this->model->delete();
		return true;
		
	}
}