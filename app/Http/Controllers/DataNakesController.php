<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataNakesController extends Controller
{
    public function index()
    {
        return view('data-nakes.index');
    }
}