<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $data['article'] = Article::paginate(4);
        $data['feature_post'] = Article::where('selected_article', '=', 'feature_post')->first();
        $data['ads'] = Article::where('selected_article', '=', 'ads')->first();
        $data['selected_category_post_1'] = Article::where('selected_article', '=', 'selected_category_post_1')->first();
        $data['selected_category_post_2'] = Article::where('selected_article', '=', 'selected_category_post_2')->first();
        $data['editors_pick_1'] = Article::where('selected_article', '=', 'editors_pick_1')->first();
        $data['editors_pick_2'] = Article::where('selected_article', '=', 'editors_pick_2')->first();
        $data['editors_pick_3'] = Article::where('selected_article', '=', 'editors_pick_3')->first();
        $data['editors_pick_4'] = Article::where('selected_article', '=', 'editors_pick_4')->first();
        $data['editors_pick_5'] = Article::where('selected_article', '=', 'editors_pick_5')->first();
        $data['trending_1'] = Article::where('selected_article', '=', 'trending_1')->first();
        $data['trending_2'] = Article::where('selected_article', '=', 'trending_2')->first();
        $data['trending_3'] = Article::where('selected_article', '=', 'trending_3')->first();
        $data['trending_4'] = Article::where('selected_article', '=', 'trending_4')->first();
        $data['trending_5'] = Article::where('selected_article', '=', 'trending_5')->first();
        $data['trending_6'] = Article::where('selected_article', '=', 'trending_6')->first();
        $data['event_1'] = Article::where('selected_article', '=', 'event_1')->first();
        $data['event_2'] = Article::where('selected_article', '=', 'event_2')->first();
        return view('back.page.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
