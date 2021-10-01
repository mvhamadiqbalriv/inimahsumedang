<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Ad;
use DB;
use Alert;
use Storage;
use Str;
use Auth;

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
        $data['feature_post'] = Article::where('feature_post', '=', 'feature_post')->paginate(3);
        $data['horizontal_ads'] = Ad::where('status', '=', 'horizontal_ads')->first();
        $data['search_horizontal_ads'] = Ad::where('status', '=', 'search_horizontal_ads')->first();
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

        $data['feature_post_pagination'] = Article::where('is_publish', '=', '1')->where('feature_post', '=', null)->paginate(3);
        $data['trending_pagination'] = Article::join("visitors", "visitors.article", "=", "articles.id")
            ->where("visitors.created_at", ">=", date("Y-m-d H:i:s", strtotime('-24 hours', time())))
            ->where("trending", "=", null)
            ->groupBy("articles.id")
            ->orderBy(DB::raw('COUNT(articles.id)'), 'desc')
            ->select('articles.*', DB::raw('COUNT(articles.id) as total_views'))
            ->limit(6)
            ->paginate(3);
        $data['editors_pick_pagination'] = Article::where('is_publish', '=', '1')->where('editors_pick', '=', null)->paginate(3);
        $data['event_pagination'] = Article::where('is_publish', '=', '1')->where('event', '=', null)->paginate(3);
        $data['category_post_pagination'] = Article::where('is_publish', '=', '1')->where('category_post', '=', null)->paginate(3);

         
        return view('back.page.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    function featurePostList(Request $request)
    {
        if($request->ajax()){
            $feature_post = Article::where('feature_post', '=', 'feature_post')->paginate(3);
            return view('back.page.feature_post_list', compact('feature_post'))->render();
        }
    }
    
    function featurePost(Request $request)
    {
        if($request->ajax()){
            $feature_post_pagination = Article::where('is_publish', '=', '1')->where('feature_post', '=', null)->paginate(3);
            return view('back.page.pagination.feature_post', compact('feature_post_pagination'))->render();
        }
    }


    function slideShow(Request $request)
    {
        if($request->ajax()){
            $slideshow_pagination = Article::where('is_publish', '=', '1')->where('slide_show', '=', null)->paginate(3);
            return view('back.page.pagination.feature_post', compact('slideshow_pagination'))->render();
        }
    }

    function editorsPick(Request $request)
    {
        if($request->ajax()){
            $editors_pick_pagination = Article::where('is_publish', '=', '1')->where('editors_pick', '=', null)->paginate(3);
            return view('back.page.pagination.editors_pick', compact('editors_pick_pagination'))->render();
        }
    }

    function event(Request $request)
    {
        if($request->ajax()){
            $event_pagination = Article::where('is_publish', '=', '1')->where('event', '=', null)->paginate(3);
            return view('back.page.pagination.event', compact('event_pagination'))->render();
        }
    }

    function categoryPost(Request $request)
    {
        if($request->ajax()){
            $category_post_pagination = Article::where('is_publish', '=', '1')->where('category_post', '=', null)->paginate(3);
            return view('back.page.pagination.category_post', compact('category_post_pagination'))->render();
        }
    }

    function trending(Request $request)
    {
        if($request->ajax()){
            $trending_pagination = Article::join("visitors", "visitors.article", "=", "articles.id")
            ->where('judul','LIKE',"%{$search_val}%")
            ->where('trending_selected', '=', null)
            ->where('is_publish', '=', '1')
            ->where("visitors.created_at", ">=", date("Y-m-d H:i:s", strtotime('-24 hours', time())))
            ->groupBy("articles.id")
            ->orderBy(DB::raw('COUNT(articles.id)'), 'desc')
            ->limit(3)
            ->get([DB::raw('COUNT(articles.id) as total_views'), 'articles.*']);
            return view('back.page.pagination.trending', compact('trending_pagination'))->render();
        }
    }

    public function featurePostSearch(Request $request)
    {
        $search_val = $request->id;
        $data['article'] = Article::where('judul','LIKE',"%{$search_val}%")->where('is_publish', '=', '1')->where('feature_post', '=', null)->limit(3)->get();
        return view('back.page.search.search_live', $data);
    }

    public function slideShowSearch(Request $request)
    {
        $search_val = $request->id;
        $data['article'] = Article::where('judul','LIKE',"%{$search_val}%")->where('is_publish', '=', '1')->where('slide_show', '=', null)->limit(3)->get();
        return view('back.page.search.search_live', $data);
    }

    public function editorsPickSearch(Request $request)
    {
        $search_val = $request->id;
        $data['article'] = Article::where('judul','LIKE',"%{$search_val}%")->where('is_publish', '=', '1')->where('editors_pick', '=', null)->limit(3)->get();
        return view('back.page.search.search_live', $data);
    }

    public function eventSearch(Request $request)
    {
        $search_val = $request->id;
        $data['article'] = Article::where('judul','LIKE',"%{$search_val}%")->where('is_publish', '=', '1')->where('event', '=', null)->limit(3)->get();
        return view('back.page.search.search_live', $data);
    }

    public function categoryPostSearch(Request $request)
    {
        $search_val = $request->id;
        $data['article'] = Article::where('judul','LIKE',"%{$search_val}%")->where('is_publish', '=', '1')->where('category_post', '=', null)->limit(3)->get();
        return view('back.page.search.search_live', $data);
    }

    public function trendingSearch(Request $request)
    {
        $search_val = $request->id;
        $data['article'] = Article::join("visitors", "visitors.article", "=", "articles.id")
        ->where('judul','LIKE',"%{$search_val}%")
        ->where('is_publish', '=', '1')
        ->where("visitors.created_at", ">=", date("Y-m-d H:i:s", strtotime('-24 hours', time())))
        ->groupBy("articles.id")
        ->orderBy(DB::raw('COUNT(articles.id)'), 'desc')
        ->limit(3)
        ->get([DB::raw('COUNT(articles.id) as total_views'), 'articles.*']);
        return view('back.page.search.search_live', $data);
    }
    
    public function selectedContent(Request $request, Article $article)
    {
        $data = [
            'judul' => $article->judul,
            'slug' => Str::slug($article->judul),
            'gambar' => $request->hasFile('gambar') ? $gambar : $article->gambar,
            'konten' => $article->konten,
            'tag' => $article->tag,
            'creator' => Auth::user()->id,
            'category' => $article->category,
            'is_publish' => "1",
            'editors_pick_selected' => $request->editors_pick_selected ? $request->editors_pick_selected : $article->editors_pick_selected,
            'trending_selected' => $request->trending_selected ? $request->trending_selected : $article->trending_selected,
            'event_selected' => $request->event_selected ? $request->event_selected : $article->event_selected,
            'category_post_selected' => $request->category_post_selected ? $request->category_post_selected : $article->category_post_selected,
            'feature_post' => $request->feature_post_selected ? $request->feature_post_selected : $article->feature_post,
            'editors_pick' => $request->editors_pick_selected ? $request->editors_pick_selected : $article->editors_pick,
            'trending' => $request->trending_selected ? $request->trending_selected : $article->trending,
            'event' => $request->event_selected ? $request->event_selected : $article->event_selected,
            'category_post' => $request->category_post_selected ? $request->category_post_selected : $article->category_post,
        ];


        if($request->category_post_selected == 'selected_category_post_1')
        {
            if(Article::where('category_post_selected', '=', 'selected_category_post_1')->first())
            {
                $selected = Article::where('category_post_selected', '=', 'selected_category_post_1')->first();
                $selected->update(['category_post_selected' => null]);
            }

            if(Article::where('category_post', '=', 'selected_category_post_1')->first())
            {
                $selected = Article::where('category_post', '=', 'selected_category_post_1')->first();
                $selected->update(['category_post' => null]);
            }
        }

        if($request->category_post_selected == 'selected_category_post_2')
        {
            if(Article::where('category_post_selected', '=', 'selected_category_post_2')->first())
            {
                $selected = Article::where('category_post_selected', '=', 'selected_category_post_2')->first();
                $selected->update(['category_post_selected' => null]);
            }

            if(Article::where('category_post', '=', 'selected_category_post_2')->first())
            {
                $selected = Article::where('category_post', '=', 'selected_category_post_2')->first();
                $selected->update(['category_post' => null]);
            }
        }

        if($request->editors_pick_selected == 'editors_pick_1')
        {
            if(Article::where('editors_pick_selected', '=', 'editors_pick_1')->first())
            {
                $selected = Article::where('editors_pick_selected', '=', 'editors_pick_1')->first();
                $selected->update(['editors_pick_selected' => null]);
            }

            if(Article::where('editors_pick', '=', 'editors_pick_1')->first())
            {
                $selected = Article::where('editors_pick', '=', 'editors_pick_1')->first();
                $selected->update(['editors_pick' => null]);
            }
        }

        if($request->editors_pick_selected == 'editors_pick_2')
        {
            if(Article::where('editors_pick_selected', '=', 'editors_pick_2')->first())
            {
                $selected = Article::where('editors_pick_selected', '=', 'editors_pick_2')->first();
                $selected->update(['editors_pick_selected' => null]);
            }

            if(Article::where('editors_pick', '=', 'editors_pick_2')->first())
            {
                $selected = Article::where('editors_pick', '=', 'editors_pick_2')->first();
                $selected->update(['editors_pick' => null]);
            }
        }

        if($request->editors_pick_selected == 'editors_pick_3')
        {
            if(Article::where('editors_pick_selected', '=', 'editors_pick_3')->first())
            {
                $selected = Article::where('editors_pick_selected', '=', 'editors_pick_3')->first();
                $selected->update(['editors_pick_selected' => null]);
            }

            if(Article::where('editors_pick', '=', 'editors_pick_3')->first())
            {
                $selected = Article::where('editors_pick', '=', 'editors_pick_3')->first();
                $selected->update(['editors_pick' => null]);
            }
        }

        if($request->editors_pick_selected == 'editors_pick_4')
        {
            if(Article::where('editors_pick_selected', '=', 'editors_pick_4')->first())
            {
                $selected = Article::where('editors_pick_selected', '=', 'editors_pick_4')->first();
                $selected->update(['editors_pick_selected' => null]);
            }

            if(Article::where('editors_pick', '=', 'editors_pick_4')->first())
            {
                $selected = Article::where('editors_pick', '=', 'editors_pick_4')->first();
                $selected->update(['editors_pick' => null]);
            }
        }

        if($request->editors_pick_selected == 'editors_pick_5')
        {
            if(Article::where('editors_pick_selected', '=', 'editors_pick_5')->first())
            {
                $selected = Article::where('editors_pick_selected', '=', 'editors_pick_5')->first();
                $selected->update(['editors_pick_selected' => null]);
            }

            if(Article::where('editors_pick', '=', 'editors_pick_5')->first())
            {
                $selected = Article::where('editors_pick', '=', 'editors_pick_5')->first();
                $selected->update(['editors_pick' => null]);
            }
        }

        if($request->trending_selected == 'trending_1')
        {
            if(Article::where('trending_selected', '=', 'trending_1')->first())
            {
                $selected = Article::where('trending_selected', '=', 'trending_1')->first();
                $selected->update(['trending_selected' => null]);
            }

            if(Article::where('trending', '=', 'trending_1')->first())
            {
                $selected = Article::where('trending', '=', 'trending_1')->first();
                $selected->update(['trending' => null]);
            }
        }

        if($request->trending_selected == 'trending_2')
        {
            if(Article::where('trending_selected', '=', 'trending_2')->first())
            {
                $selected = Article::where('trending_selected', '=', 'trending_3')->first();
                $selected->update(['trending_selected' => null]);
            }

            if(Article::where('trending', '=', 'trending_2')->first())
            {
                $selected = Article::where('trending', '=', 'trending_2')->first();
                $selected->update(['trending' => null]);
            }
        }

        if($request->trending_selected == 'trending_3')
        {
            if(Article::where('trending_selected', '=', 'trending_3')->first())
            {
                $selected = Article::where('trending_selected', '=', 'trending_3')->first();
                $selected->update(['trending_selected' => null]);
            }

            if(Article::where('trending', '=', 'trending_3')->first())
            {
                $selected = Article::where('trending', '=', 'trending_3')->first();
                $selected->update(['trending' => null]);
            }
        }

        if($request->trending_selected == 'trending_4')
        {
            if(Article::where('trending_selected', '=', 'trending_4')->first())
            {
                $selected = Article::where('trending_selected', '=', 'trending_4')->first();
                $selected->update(['trending_selected' => null]);
            }

            if(Article::where('trending', '=', 'trending_4')->first())
            {
                $selected = Article::where('trending', '=', 'trending_4')->first();
                $selected->update(['trending' => null]);
            }
        }

        if($request->trending_selected == 'trending_5')
        {
            if(Article::where('trending_selected', '=', 'trending_5')->first())
            {
                $selected = Article::where('trending_selected', '=', 'trending_5')->first();
                $selected->update(['trending_selected' => null]);
            }

            if(Article::where('trending', '=', 'trending_5')->first())
            {
                $selected = Article::where('trending', '=', 'trending_5')->first();
                $selected->update(['trending' => null]);
            }
        }

        if($request->trending_selected == 'trending_6')
        {
            if(Article::where('trending_selected', '=', 'trending_6')->first())
            {
                $selected = Article::where('trending_selected', '=', 'trending_6')->first();
                $selected->update(['trending_selected' => null]);
            }

            if(Article::where('trending', '=', 'trending_6')->first())
            {
                $selected = Article::where('trending', '=', 'trending_6')->first();
                $selected->update(['trending' => null]);
            }
        }

        if($request->event_selected == 'event_1')
        {
            if(Article::where('event_selected', '=', 'event_1')->first())
            {
                $selected = Article::where('event_selected', '=', 'event_1')->first();
                $selected->update(['event_selected' => null]);
            }

            if(Article::where('event', '=', 'event_1')->first())
            {
                $selected = Article::where('event', '=', 'event_1')->first();
                $selected->update(['event' => null]);
            }
        }

        if($request->event_selected == 'event_2')
        {
            if(Article::where('event_selected', '=', 'event_2')->first())
            {
                $selected = Article::where('event_selected', '=', 'event_2')->first();
                $selected->update(['event_selected' => null]);
            }

            if(Article::where('event', '=', 'event_2')->first())
            {
                $selected = Article::where('event', '=', 'event_2')->first();
                $selected->update(['event' => null]);
            }
        }

        $article->update($data)
        ? Alert::success('Suskes', 'Artikel telah berhasil di terapkan!')
        : Alert::error('Error', 'Artikel gagal di terapkan!');

        return redirect()->route('pages.index');
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
