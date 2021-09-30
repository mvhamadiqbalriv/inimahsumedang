<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category_article;
use App\Models\Comment;
use App\Models\Reply;
use App\Models\Web;
use App\Models\Visitor;
use App\Models\Ad;
use Alert;
use DB;
use Str;

class FrontArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['article'] = Article::where('is_publish', '=', '1')->paginate(8);
        $data['web'] = Web::find(1);
        $data['title_upper'] = "Artikel";
        $data['breadcrumb'] = "Artikel";
        $data['category_select_button'] = '1';
        $data['event_1'] = Article::where('event_selected', '=', 'event_1')->first();
        $data['event_2'] = Article::where('event_selected', '=', 'event_2')->first();
        $data['widget_ads'] = Ad::where('status', '=', 'widget_ads')->first();

        return view('front.articles.index', $data);
    }



    public function pencarian_artikel(Request $request)
    {
        $pencarian = $request->pencarian;
        $data['article'] = Article::where('judul','like',"%".$pencarian."%")->paginate(8);
        $data['web'] = Web::findOrFail(1);
        $data['title_upper'] = "Hasil Pencarian";
        $data['breadcrumb'] = "Hasil Pencarian";
        return view('front.articles.index', $data);
    }

    public function tag(Request $request)
    {
        $tag = $request->tagValue;
        $data['article'] = Article::where('tag','like',"%".$tag."%")->paginate(8);
        $data['web'] = Web::findOrFail(1);
        $data['title_upper'] = "#" . $tag;
        $data['breadcrumb'] = "Tag";

        return view('front.articles.index', $data);
    }

    public function kategori(Request $request)
    {
        $data['title_upper'] = "Kategori";
        $data['breadcrumb'] = "Kategori";
        $data['web'] = Web::findOrFail(1);
        $data['category_select_button'] = '1';

        $kategori = $request->kategori;
        
        if ($kategori == 'semua') {
            return redirect()->route('artikel.index');
        } else {
            if(Article::where('category', '=', $kategori)->count() < 1) {
                $data['peringatan'] = 'Maaf, artikel dalam kategori ini belum tersedia.';
            }
            $data['article'] = Article::where('category', '=', $kategori)->paginate(8);

        }

        return view('front.articles.index', $data, compact('kategori'));
    }
    
    public function cari_artikel(Request $request) 
    {
        $cari = $request->cari;

        

    }
    public function pencarian_autocomplete(Request $request)
    {
        $search = $request->search;


        if($search == ''){
  
           $autocomplate = Article::orderby('judul','asc')->select('id','judul')->limit(5)->get();

        }else{
  
           $autocomplate = Article::orderby('judul','asc')->select('id','judul')->where('judul', 'like', '%' .$search . '%')->limit(5)->get();

        }
  
  
        $response = array();
  
        foreach($autocomplate as $autocomplate){
  
           $response[] = array("value"=>$autocomplate->id,"label"=>$autocomplate->judul);
  
        }
  
  
        echo json_encode($response);
  
        exit;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function komentar(Request $request) {

        $data = [
            'nama' => $request->nama,
            'comment' => $request->comment,
            'email' => $request->email,
            'web' => $request->web,
            'article' => $request->article_id,
        ];

        Comment::create($data)
        ? Alert::success('Berhasil', 'Komentar telah berhasil dikirim')
        : Alert::error('Error', 'Komentar gagal di dikirim!');
        
        return redirect()->back();
    }


    public function reply(Request $request) {
        $data = [
            'nama' => $request->nama,
            'reply' => $request->reply,
            'email' => $request->email,
            'web' => $request->web,
            'comment' => $request->comment_id,
        ];

        Reply::create($data)
        ? Alert::success('Berhasil', 'Balasan telah berhasil dikirim')
        : Alert::error('Error', 'Balasan gagal di dikirim');

        return redirect()->back();
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
    public function show($slug, Request $request)
    {
        $data['widget_ads'] = Ad::where('status', '=', 'widget_ads')->first();
        $data['event_1'] = Article::where('event_selected', '=', 'event_1')->first();
        $data['event_2'] = Article::where('event_selected', '=', 'event_2')->first();
        $article = Article::where('slug', $slug)->first();
        Visitor::createViewLog($article);
        return view('front.article_contents.index', $data, ['article' => $article]); 
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
