<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthorController extends Controller
{
    public function author($username)
    {
        $data['author'] = User::where('username', $username)->get();
        
        return view('front.author.index', $data);
    }
}
