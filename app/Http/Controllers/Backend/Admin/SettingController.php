<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Settings;

class SettingController extends Controller
{
	protected $setting;

    public function __construct(Settings $setting) 
    {
    	$this->middleware('admin');
    	$this->setting = $setting;
    }

    // Site Settings
    public function index() 
    {
    	return view('backend.pages.setting');
    }

    // For Exios
    public function axios(Request $request)
    {
        return $this->setting->createOrUpdate($request);
    }

    // Fetch Setting Data
    public function getData()
    {
        return json_encode($this->setting->get());
    }

    // Fetch Setting Data
    public function get()
    {
        return $this->setting->get();
    }
}
