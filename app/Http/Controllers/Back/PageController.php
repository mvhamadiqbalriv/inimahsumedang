<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Ad;
use DB;
use Alert;
use Storage;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $data['article'] = Article::all();
        $data['feature_post'] = Article::where('feature_post_selected', '=', 'feature_post')->first();
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
        $data['selectedArticle'] = Article::paginate(3);
        $data['artikelAjax'] = Article::join("visitors", "visitors.article", "=", "articles.id")
            ->where("visitors.created_at", ">=", date("Y-m-d H:i:s", strtotime('-24 hours', time())))
            ->where("trending", "=", null)
            ->groupBy("articles.id")
            ->orderBy(DB::raw('COUNT(articles.id)'), 'desc')
            ->select('articles.*', DB::raw('COUNT(articles.id) as total_views'))
            ->limit(6)
            ->paginate(3);
          


        if ($request->ajax()) {
            return view('trending_article', $data);
        }
         
        return view('back.page.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function featurePostSearch(Request $request)
    {
        $search_val = $request->id;
        if (is_null($search_val))
        {
            return view('searchlive');
        } else {
            $data['article'] = Article::where('judul','LIKE',"%{$search_val}%")->where('is_publish', '=', '1')->where('feature_post', '=', null)->limit(3)->get();
            return view('search_live_article', $data);
        }
    }

    public function editorsPickSearch(Request $request)
    {
        $search_val = $request->id;
        if (is_null($search_val))
        {
            return view('searchlive');
        } else {
            $data['article'] = Article::where('judul','LIKE',"%{$search_val}%")->where('is_publish', '=', '1')->where('editors_pick', '=', null)->limit(3)->get();
            return view('search_live_article', $data);
        }
    }

    public function eventSearch(Request $request)
    {
        $search_val = $request->id;
        if (is_null($search_val))
        {
            return view('searchlive');
        } else {
            $data['article'] = Article::where('judul','LIKE',"%{$search_val}%")->where('is_publish', '=', '1')->where('event', '=', null)->limit(3)->get();
            return view('search_live_article', $data);
        }
    }

    public function categoryPostSearch(Request $request)
    {
        $search_val = $request->id;
        if (is_null($search_val))
        {
            return view('searchlive');
        } else {
            $data['article'] = Article::where('judul','LIKE',"%{$search_val}%")->where('is_publish', '=', '1')->where('category_post', '=', null)->limit(3)->get();
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
            ->where('trending_selected', '=', null)
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
    public function ads(Request $request, Ad $ad)
    {
        
        $request->validate([
            'gambar' => 'required',
            'tautan' => 'required',
            'status' => 'required'
        ]);

        $data = [
            'gambar' => $request->file('gambar')->store('/public/input/ads'),
            'tautan' => $request->tautan,
            'status' => $request->status
        ];

       
        Ad::create($data)
        ? Alert::success('Berhasil', 'Iklan telah berhasil diterapkan!')
        : Alert::error('Error', 'Ikbal gagal diterapkan');

        return redirect()->back();
    }

    
        public function ads_update(Request $request, $id)
        {
            $request->validate([
                'tautan' => 'required',
                'status' => 'required'
            ]);

            $ads = Ad::findOrFail($id);
            if ($request->hasFile('gambar')) {
                if (Storage::exists($ads->gambar) && !empty($ads->gambar)) { 
                    Storage::delete($ads->gambar);
                }
                $gambar = $request->file('gambar')->store("/public/input/articles");
            }
    
            $data = [
                'gambar' => $request->hasFile('gambar') ? $gambar : $ads->gambar,
                'tautan' => $request->tautan ? $request->tautan : $ads->tautan,
                'status' => $request->status
    
            ];
            
           
            $ads->update($data)
            ? Alert::success('Suskes', 'Iklan telah berhasil diterapkan!')
            : Alert::error('Error', 'Iklan gagal diterapkan!');
    
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
