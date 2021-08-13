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

    public function searchlive(Request $request)
    {
        $search_val = $request->id;
        if (is_null($search_val))
        {
            return view('searchlive');
        } else {
            $data['article'] = Article::where('judul','LIKE',"%{$search_val}%")->where('is_publish', '=', '1')->where('selected_article', '=', null)->limit(3)->get();
            return view('searchLiveajax', $data);
        }
    }
}
