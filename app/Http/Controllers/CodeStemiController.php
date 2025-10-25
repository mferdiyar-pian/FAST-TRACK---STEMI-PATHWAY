<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CodeStemiController extends Controller
{
    public function index()
    {
        return view('code-stemi.index');
    }
}