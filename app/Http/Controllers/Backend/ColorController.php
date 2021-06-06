<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Models;
use App\Interfaces\Model;

class ColorController extends Controller
{
    protected $color;

    function __construct() 
    {
        $this->color = new Models("Color");
    }

    // index
    public function index()
    {
        return view('backend.pages.others.color');
    }

    // All
    public function all(Model $mdl)
    { 
        $colors = $mdl->model('Color')->orderBy('id', 'DESC')->get(['id', 'name', 'code'])->toArray();
        return response()->json($colors, 200);
    }

    // store
    public function store(Request $request, Model $mdl)
    {
        $data = $request->except(['_token']);
        $mdl->model('Color')->create($data);

        $result = $mdl->model('Color')->orderBy('id', 'DESC')->get()->toArray();
        return response()->json($result, 200);
    }

    // update
    public function update(Request $request, Model $mdl, $id)
    {
        
        $data = $request->except(['_token']);
        $mdl->model('Color')->find(['id'=>$id])->update($data);
            
        $result = new Models('Color');
        $result = $result->orderBy('id', 'DESC')->get()->toArray();
        return response()->json($result, 200);
    }

    // delete
    public function delete($id)
    {
        $this->color->find(['id'=>$id])->delete();
        $result = new Models('Color');
        $result = $result->orderBy('id', 'DESC')->get()->toArray();
        return response()->json($result, 200);
    }
}
