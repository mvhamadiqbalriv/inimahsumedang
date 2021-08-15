<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Web;
use DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['recent_article'] = Article::orderBy('updated_at', 'desc')->take(4)->get();
        $data['web'] = Web::find(1);
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

        $data['popular'] = Article::join("visitors", "visitors.article", "=", "articles.id")
            // ->where("visitors.created_at", ">=", now()->subdays(1))
            ->groupBy("articles.id")
            ->orderBy(DB::raw('COUNT(articles.id)'), 'desc')
            ->limit(4)//here its very minute mistake of a paranthesis in Jean Marcos' answer, which results ASC ordering instead of DESC so be careful with this line
            ->get([DB::raw('COUNT(articles.id) as total_views'), 'articles.*']);
          
            $data['trending'] = Article::join("visitors", "visitors.article", "=", "articles.id")
            ->where("visitors.created_at", ">=", date("Y-m-d H:i:s", strtotime('-24 hours', time())))
            ->groupBy("articles.id")
            ->orderBy(DB::raw('COUNT(articles.id)'), 'desc')
            ->limit(4)//here its very minute mistake of a paranthesis in Jean Marcos' answer, which results ASC ordering instead of DESC so be careful with this line
            ->get([DB::raw('COUNT(articles.id) as total_views'), 'articles.*']);
        return view('front.home.index', $data);
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
        //
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
