<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Ad;
use DB;
use Alert;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $data['article'] = Article::all();
        $data['feature_post'] = Article::where('selected_article', '=', 'feature_post')->first();
        $data['horizontal_ads'] = Ad::where('status', '=', 'horizontal_ads')->first();
        $data['widget_ads'] = Ad::where('status', '=', 'widget_ads')->first();
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

    public function searchlive(Request $request)
    {
        $search_val = $request->id;
        if (is_null($search_val))
        {
            return view('searchlive');
        } else {
            $data['article'] = Article::where('judul','LIKE',"%{$search_val}%")->where('is_publish', '=', '1')->where('selected_article', '=', null)->limit(3)->get();
            return view('search_live_article', $data);
        }
    }

    public function searchliveTrending(Request $request)
    {
        $search_val = $request->id;
        if (is_null($search_val))
        {
            return view('searchlive');
        } else {
            $data['article'] = Article::join("visitors", "visitors.article", "=", "articles.id")
            ->where('judul','LIKE',"%{$search_val}%")
            ->where('selected_article', '=', null)
            ->where('is_publish', '=', '1')
            ->where("visitors.created_at", ">=", date("Y-m-d H:i:s", strtotime('-24 hours', time())))
            ->groupBy("articles.id")
            ->orderBy(DB::raw('COUNT(articles.id)'), 'desc')
            ->limit(3)
            ->get([DB::raw('COUNT(articles.id) as total_views'), 'articles.*']);
            return view('search_live_trending_article', $data);
        }
    }
    

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
    public function ads(Request $request)
    {
        if($request->status == 'horizontal_ads'){
            Ad::where('status', 'horizontal_ads')->delete();
        }

        if($request->status == 'widget_ads'){
            Ad::where('status', 'widget_ads')->delete();
        }

        $request->validate([
            'gambar' => 'required',
            'status' => 'required'
        ]);

        $data = [
            'gambar' => $request->file('gambar')->store('/public/input/ads'),
            'status' => $request->status
        ];

        Ad::create($data)
        ? Alert::success('Berhasil', 'Iklan telah berhasil diterapkan!')
        : Alert::error('Error', 'Ikbal gagal diterapkan');

        return redirect()->back();
    }
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
