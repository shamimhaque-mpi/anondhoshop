<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct() 
    {
    	$this->middleware('admin');
    }

    // Index 
    Public function index()
    {
    	return view('backend.pages.add.list');
    }

    // Add Form Show
    Public function Add() 
    {
    	return view('backend.pages.admin.add');
    }
}
