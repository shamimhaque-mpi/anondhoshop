<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Models;

class UnitController extends Controller
{
    protected $unit;

    function __construct() 
    {
        $this->unit = new Models("Unit");
    }

    // index
    public function index()
    {
        return view('backend.pages.others.unit');
    }

    // All
    public function all()
    { 
        $units = $this->unit->orderBy('id', 'DESC')->get()->toArray();
        return response()->json($units, 200);
    }

    // store
    public function store(Request $request)
    {
        $data = $request->except(['_token']);
        $this->unit->create($data);

        $result = $this->unit->orderBy('id', 'DESC')->get()->toArray();
        return response()->json($result, 200);
    }

    // update
    public function update(Request $request, $id)
    {
        
        $data = $request->except(['_token']);
        $this->unit->find(['id'=>$id])->update($data);
            
        $result = new Models("Unit");
        $result = $result->orderBy('id', 'DESC')->get()->toArray();
        return response()->json($result, 200);
    }

    // delete
    public function delete($id)
    {
        $this->unit->find(['id'=>$id])->delete();
        $result = new Models("Unit");
        $result = $result->orderBy('id', 'DESC')->get()->toArray();
        return response()->json($result, 200);
    }
}
