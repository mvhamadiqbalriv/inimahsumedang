<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Ad;
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
        $data['feature_post'] = Article::all();
        $data['horizontal_ads'] = Ad::where('status', '=', 'horizontal_ads')->first();
        $data['widget_ads'] = Ad::where('status', '=', 'widget_ads')->first();
        $data['selected_category_post_1'] = Article::where('category_post_selected', '=', 'selected_category_post_1')->first();
        $data['selected_category_post_2'] = Article::where('category_post_selected', '=', 'selected_category_post_2')->first();
        $data['editors_pick_1'] = Article::where('editors_pick_selected', '=', 'editors_pick_1')->first();
        $data['editors_pick_2'] = Article::where('editors_pick_selected', '=', 'editors_pick_2')->first();
        $data['editors_pick_3'] = Article::where('editors_pick_selected', '=', 'editors_pick_3')->first();
        $data['editors_pick_4'] = Article::where('editors_pick_selected', '=', 'editors_pick_4')->first();
        $data['editors_pick_5'] = Article::where('editors_pick_selected', '=', 'editors_pick_5')->first();
        $data['trending_1'] = Article::where('trending_selected', '=', 'trending_1')->first();
        $data['trending_2'] = Article::where('trending_selected', '=', 'trending_2')->first();
        $data['trending_3'] = Article::where('trending_selected', '=', 'trending_3')->first();
        $data['trending_4'] = Article::where('trending_selected', '=', 'trending_4')->first();
        $data['trending_5'] = Article::where('trending_selected', '=', 'trending_5')->first();
        $data['trending_6'] = Article::where('trending_selected', '=', 'trending_6')->first();
        $data['event_1'] = Article::where('event_selected', '=', 'event_1')->first();
        $data['event_2'] = Article::where('event_selected', '=', 'event_2')->first();

        // $data['popular'] = Article::join("visitors", "visitors.article", "=", "articles.id")
        //     // ->where("visitors.created_at", ">=", now()->subdays(1))
        //     ->groupBy("articles.id")
        //     ->orderBy(DB::raw('COUNT(articles.id)'), 'desc')
        //     ->limit(4)
        //     ->get([DB::raw('COUNT(articles.id) as total_views'), 'articles.*']);
          
            $data['popular'] = Article::join("visitors", "visitors.article", "=", "articles.id")
            ->where("visitors.created_at", ">=", date("Y-m-d H:i:s", strtotime('-24 hours', time())))
            ->groupBy("articles.id")
            ->orderBy(DB::raw('COUNT(articles.id)'), 'desc')
            ->limit(4)
            ->get([DB::raw('COUNT(articles.id) as total_views'), 'articles.*']);
        return view('front.home.index', $data);
    }
    
    public function about()
    {
        $data['web'] = Web::find(1);
        return view('front.home.about', $data);
    }
    
    public function contact()
    {
        $data['web'] = Web::find(1);
        return view('front.home.contact', $data);
    }
}
