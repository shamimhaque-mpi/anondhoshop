<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Models;

class SizeController extends Controller
{
    protected $size;

    function __construct() 
    {
        $this->size = new Models("Size");
    }

    // index
    public function index()
    {
        return view('backend.pages.others.size');
    }

    // All
    public function all()
    { 
        $sizes = $this->size->orderBy('id', 'DESC')->get()->toArray();
        return response()->json($sizes, 200);
    }

    // store
    public function store(Request $request)
    {
        $data = $request->except(['_token']);
        $this->size->create($data);

        $result = $this->size->orderBy('id', 'DESC')->get()->toArray();
        return response()->json($result, 200);
    }

    // update
    public function update(Request $request, $id)
    {
        
        $data = $request->except(['_token']);
        $this->size->find(['id'=>$id])->update($data);
            
        $result = new Models('Size');
        $result = $result->orderBy('id', 'DESC')->get()->toArray();
        return response()->json($result, 200);
    }

    // delete
    public function delete($id)
    {
        $this->size->find(['id'=>$id])->delete();
        $result = new Models('Size');
        $result = $result->orderBy('id', 'DESC')->get()->toArray();
        return response()->json($result, 200);
    }
}
