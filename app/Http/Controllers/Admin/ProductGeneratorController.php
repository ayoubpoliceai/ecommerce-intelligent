<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductGeneratorController extends Controller
{
    public function index()
{
    return view('admin.categories.create'); // Sans données pour voir si la vue se charge
}
}
