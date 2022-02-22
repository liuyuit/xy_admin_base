<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class LaravueController extends Controller
{
    public function index() {
        return view('index');
    }
}
