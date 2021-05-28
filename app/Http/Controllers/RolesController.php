<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function index(){
        return view('pages.peran.index');
    }
    public function create(){
        return view('pages.peran.create');
    }
}
