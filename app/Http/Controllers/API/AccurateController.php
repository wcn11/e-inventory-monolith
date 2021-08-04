<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccurateController extends Controller
{
    protected $request;

    protected $permissionRepository;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getAuthorize(){

        return $this->request->all();

    }
}
