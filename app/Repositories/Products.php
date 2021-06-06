<?php

namespace App\Repositories;
use App\Interfaces\Product;
use App\Repositories\Models;
use App\Repositories\Images;

class Products implements Product
{
	protected $request, $new_img_info, $old_img_info;

	public function save($request)
	{
		$this->request = $request;
		/*
		 * ++++++++++++++++++++++++++++
		 *	Insert Data into product 
		 *  table and get product id here
		 * +++++++++++++++++++++++++++++++++++
		*/
		$product 	= new Models('Product');
		$product = $product->create(
		[
			'name' 				  		=> $request->name,
			'purchase_price' 	  		=> $request->purchase_price,
			'regular_price' 	  		=> $request->regular_price,
			'min_sale_quantity'   		=> $request->min_sale_quantity,
			'unit_id' 			  		=> $request->unit_id,
			'description' 		  		=> $request->description,
			'discount_persentige' 		=> $request->discount_persentige,
			'discount_flat' 	  		=> $request->discount_flat,
			'present_sale_price'  		=> $request->present_sale_price,
			'brand_id'  		  		=> $request->brand_id,
			'total_discount_persentige' => $request->total_dis_pers,
		], ['slug'=>'name']);
		
		$this->category($product->id);
		$this->subcategory($product->id);
		$this->subsubcategory($product->id);
		$this->size($product->id);
		$this->color($product->id);
		$this->image($product->id);
		session()->flash('success', 'Your Product Saved Successful..');
		return $product->id;
	}

	public function update($request, $id)
	{
		$this->request = $request;
		// Proccess The New Images
		$this->imageProccess();
		/*
		 * ++++++++++++++++++++++++++++
		 *	Insert Data into product 
		 *  table and get product id here
		 * +++++++++++++++++++++++++++++++++++
		*/
		$product 	= new Models('Product');
		$product->find(['id'=>$id])->update(
		[
			'name' 				  		=> $request->name,
			'purchase_price' 	  		=> $request->purchase_price,
			'regular_price' 	  		=> $request->regular_price,
			'min_sale_quantity'   		=> $request->min_sale_quantity,
			'unit_id' 			  		=> $request->unit_id,
			'description' 		  		=> $request->description,
			'discount_persentige' 		=> $request->discount_persentige,
			'discount_flat' 	  		=> $request->discount_flat,
			'present_sale_price'  		=> $request->present_sale_price,
			'brand_id'  		  		=> $request->brand_id,
			'total_discount_persentige' => $request->total_dis_pers,
		]);
		
		// Delete Old Data
		$subSubCategory = new Models('ProductSubSubCategory');
		$subCategory = new Models('ProductSubCategory');
		$category = new Models('CategoryProduct');
		$color = new Models('ProductColor');
		$size = new Models('ProductSize');
		$size->find(['product_id'=>$id])->limit(100)->delete();
		$color->find(['product_id'=>$id])->limit(100)->delete();
		$category->find(['product_id'=>$id])->limit(100)->delete();
		$subCategory->find(['product_id'=>$id])->limit(100)->delete();
		$subSubCategory->find(['product_id'=>$id])->limit(100)->delete();

		// New Insert
		$this->category($id);
		$this->subcategory($id);
		$this->subsubcategory($id);
		$this->imageUpdate($id);
		$this->color($id);
		$this->size($id);
		session()->flash('success', 'Your Product Info Update Successful..');
		return $id;
	}

	/*
	 * ++++++++++++++++++++++++++++
	 *  Upload Porduct Color
	 * ++++++++++++++++++++++++++++++
	*/

	private function color($product_id)
	{
		if($this->request->m_color){
			$colors = explode(',', $this->request->m_color);
			$color  = new Models('ProductColor');
			foreach($colors as $value) {
				$color->create([
					'product_id' => $product_id,
					'color_id'	 => $value,
				]);
			}
		}
		return true;
	}

	/*
	 * ++++++++++++++++++++++++++++
	 *  Insert Porduct Category
	 * ++++++++++++++++++++++++++++++
	*/
	private function size($product_id)
	{
		if($this->request->m_size){
			$sizes = explode(',', $this->request->m_size);
			$size  = new Models('ProductSize');
			foreach($sizes as $value) {
				$size->create([
					'product_id' => $product_id,
					'size_id'	 => $value,
				]);
			}
		}
		return true;
	}

	/*
	 * ++++++++++++++++++++++++++++
	 *  Insert Porduct Color
	 * ++++++++++++++++++++++++++++++
	*/
	private function category($product_id)
	{
		if($this->request->cat_id){
			$categories = explode(',', $this->request->cat_id);
			$category   = new Models('CategoryProduct');
			foreach($categories as $value) {
				$category->create([
					'product_id'  => $product_id,
					'category_id' => $value,
				]);
			}
		}
		return true;
	}

	/*
	 * ++++++++++++++++++++++++++++
	 *  Insert Porduct Color
	 * ++++++++++++++++++++++++++++++
	*/
	private function subcategory($product_id)
	{
		if($this->request->sub_cat_id){
			$subcategories = explode(',', $this->request->sub_cat_id);
			$subcategory   = new Models('ProductSubCategory');
			foreach($subcategories as $value) {
				$subcategory->create([
					'product_id' 		=> $product_id,
					'sub_category_id'	=> $value,
				]);
			}
		}
		return true;
	}

	/*
	 * ++++++++++++++++++++++++++++
	 *  Insert Porduct Color
	 * ++++++++++++++++++++++++++++++
	*/
	private function subsubcategory($product_id)
	{
		if($this->request->sub_sub_cat_id){
			$subsubcategories = explode(',', $this->request->sub_sub_cat_id);
			$subsubcategory   = new Models('ProductSubSubCategory');
			foreach($subsubcategories as $value){
				$subsubcategory->create([
					'product_id' 			=> $product_id,
					'sub_sub_category_id'	=> $value,
				]);
			}
		}
		return true;
	}

	/*
	 * ++++++++++++++++++++++++++++
	 *	Multiple Image 
	 *  Upload With Color Or Size
	 * ++++++++++++++++++++++++++++++
	*/
	private function image($product_id)
	{
		$images 	= $this->request->image;
		$img_infos 	= json_decode($this->request->img_info, true);

    	$imageObj = new Images;
    	$imageMdl = new Models('Image');

		foreach ($images as $key => $value) 
		{
			$image = $images[$key];
			$color = ($img_infos[$key]['color'] != "" ? $img_infos[$key]['color'] : null);
			$size  = ($img_infos[$key]['size'] != "" ? $img_infos[$key]['size'] : null);

			$large   	= $imageObj->image($value)->resize(700, 700)->save('public/images/product/large', time()+$key);
			$medium  	= $imageObj->image($value)->resize(500, 500)->save('public/images/product/medium', time()+$key);
			$small 	 	= $imageObj->image($value)->resize(300, 300)->save('public/images/product/small', time()+$key);
			$smaller 	= $imageObj->image($value)->resize(150, 150)->save('public/images/product/smaller', time()+$key);

			$imageMdl 	= $imageMdl->create(
			[
				'large'		=> $large,
				'medium'	=> $medium,
				'small'		=> $small,
				'smaller'	=> $smaller,
				'product_id'=> $product_id,
				'color_id'	=> $color,
				'size_id'	=> $size,
			]);
		}
		return $imageMdl;
	}
	private function imageUpdate($product_id)
	{
		$images 		= $this->request->image;
		$img_infos 		= $this->new_img_info;
		$old_img_infos 	= $this->old_img_info;

    	$imageObj = new Images;
    	$imageMdl = new Models('Image');
    	if($images){
			foreach ($images as $key => $value) 
			{
				$image = $images[$key];
				$color = ($img_infos[$key]['color'] != "" ? $img_infos[$key]['color'] : null);
				$size  = ($img_infos[$key]['size'] != "" ? $img_infos[$key]['size'] : null);

				$large   = $imageObj->image($value)->resize(700, 700)->save('public/images/product/large', time()+$key);
				$medium  = $imageObj->image($value)->resize(500, 500)->save('public/images/product/medium', time()+$key);
				$small 	 = $imageObj->image($value)->resize(300, 300)->save('public/images/product/small', time()+$key);
				$smaller = $imageObj->image($value)->resize(150, 150)->save('public/images/product/smaller', time()+$key);

				$imageMdl = $imageMdl->create(
				[
					'large'		=> $large,
					'medium'	=> $medium,
					'small'		=> $small,
					'smaller'	=> $smaller,
					'product_id'=> $product_id,
					'color_id'	=> $color,
					'size_id'	=> $size,
				]);
			}
		}
		if($old_img_infos){
			foreach ($old_img_infos as $value) {
				$imageMdl = new Models('Image');
				$imageMdl->find(['id'=>$value['img_id']])
				->update([
					'color_id' => $value['size'],
					'size_id'  => $value['color'],
				]);
			}
		}
		return true;
	}

	private function imageProccess(){
		$img_info  = json_decode($this->request->img_info, true);
		$i=0;
        foreach ($img_info as $value) {
            if(isset($value['file'])){
                $this->new_img_info[$i]['color'] = $value['color'];
                $this->new_img_info[$i]['size']  = $value['size'];
                $i++;
            }
        }
        $j=0;
        foreach ($img_info as $value) {
            if(!isset($value['file'])){
                $this->old_img_info[$j]['color'] = $value['color'];
                $this->old_img_info[$j]['size']  = $value['size'];
                $this->old_img_info[$j]['img_id']  = $value['img_id'];
                $j++;
            }
        }
	}
}