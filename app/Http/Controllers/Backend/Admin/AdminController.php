<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Previlege;
use App\Models\Menu;
use Auth, Hash;
use App\Interfaces\Image;


class AdminController extends Controller
{ 
  private $image;

   	public function __construct(Image $image)
   	{
   		 $this->middleware('admin');
       $this->image = $image;
   	}

   	//Admin Dashboard
   	public function index()
   	{
   		 return view('backend.pages.index');
   	}

   	// list 
    Public function list()
    {
      	$admins = Admin::where('type','!=','developer')->get();
      	return view('backend.pages.admin.list', compact('admins'));
    }

    // Admin Details Information
    public function view($id)
    {
      $admin = Admin::where([['type','!=','developer'], ['id', $id]])->first();
      return view('backend.pages.admin.view', compact('admin'));
    }

    // Add Form Show
    Public function add() 
    {
    	 return view('backend.pages.admin.add');
    }

    // Store Data
    public function store(Request $request)
    {
      	$request->validate([
        		'name'      => 'required',
        		'username'  => 'required|unique:admins,username',
            'email'     => 'required|unique:admins,email',
        		'password'  => 'required|min:6'
      	]);

      	$data              = $request->except(['_token', 'password', 'photo']);
        $data['password']  = Hash::make($request->password);

        Admin::create($data);
        session()->flash('success', 'New Admin Create Successful...');
        return redirect()->route('admin.all');
    }

    // Add Form Show
    Public function edit($id) 
    {
      $admin = Admin::where('id', $id)->first();
      return view('backend.pages.admin.edit', compact('admin'));
    }

    // Add Form Show
    Public function update(Request $request, $id) 
    {

        $data     = $request->except(['_token', 'base_token', 'password', 'photo']);
        $old_info = json_decode(base64_decode($request->base_token));

        if($old_info->old_email != $data['email'] && $old_info->old_username != $data['username'])
        {
            $request->validate([
                'username'  => 'required|unique:admins,username',
                'email'     => 'required|unique:admins,email',
            ]);
        }
        else if($old_info->old_email != $data['email'])
        {
            $request->validate(['email' => 'required|unique:admins,email']);
        }
        else if($old_info->old_username != $data['username'])
        {
            $request->validate(['username' => 'required|unique:admins,username']);
        }
        if($request->password)
        {
            $request->validate(['password' => 'min:6']);
            $data['password'] = Hash::make($request->password);
        }
        if($request->photo){
          $this->image->delete(Admin::find($id)->photo);
          $data['photo'] = $this->image->image($request->photo)->resize(300)->save('public/backend/images/admins', time(), 30);
        }

        $request->validate(['name' => 'required']);

        Admin::where('id', $id)->update($data);
        session()->flash('success', 'Admin Profile Update Successful...');
        return redirect()->route('admin.all');
    }

    
    // Admin Deactive
    public function deactive($id)
    {
        Admin::where('id', $id)->update(['status'=> 0]);
        return redirect()->back();
    }

    // Admin delete
    public function delete($id)
    {
        Admin::where('id', $id)->delete();
        return redirect()->route('admin.all');
    }
}
