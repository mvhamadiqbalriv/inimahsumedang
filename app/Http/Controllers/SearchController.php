<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
class SearchController extends Controller
{
    public function index()
    {
        return view('searchlive');
    }

    
}
