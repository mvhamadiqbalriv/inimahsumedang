<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Web;
use App\Models\Category_article;
use App\Models\Ad;
use App\Models\Visitor;
use App\Models\Comment;
use Alert;
use Auth;
use Str;
use Illuminate\Support\Facades\Storage;
class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $userRole = Auth::user()->roles->pluck('name')->first();
        $data['article'] = Article::when($userRole == 'guest', function($query) {
            return $query->where('creator', Auth::id());
        })->orderBy('created_at', 'desc')->paginate(5);
        $data['published'] = Article::when($userRole == 'guest', function($query) {
            return $query->where('creator', Auth::id());
        })->where('is_publish', '=', '1')->paginate(5);
        $data['draft'] = Article::when($userRole == 'guest', function($query) {
            return $query->where('creator', Auth::id());
        })->where('is_publish', '=', '0')->paginate(5);
        $data['count_all'] = Article::when($userRole == 'guest', function($query) {
            return $query->where('creator', Auth::id());
        })->count();
        $data['count_published'] = Article::when($userRole == 'guest', function($query) {
            return $query->where('creator', Auth::id());
        })->where('is_publish', '=' , '1')->count();
        $data['count_draft'] = Article::when($userRole == 'guest', function($query) {
            return $query->where('creator', Auth::id());
        })->where('is_publish', '=' , '0')->count();
        $data['comment_count'] = Article::when($userRole == 'guest', function($query) {
            return $query->where('creator', Auth::id());
        })->with('comments')->get();
        $data['status'] = '';

        return view('back.article.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function filterArticle(Request $request)
    {
        $userRole = Auth::user()->roles->pluck('name')->first();
        $data['count_all'] = Article::when($userRole == 'guest', function($query) {
            return $query->where('creator', Auth::id());
        })->count();
        $data['count_published'] = Article::when($userRole == 'guest', function($query) {
            return $query->where('creator', Auth::id());
        })->where('is_publish', '=' , '1')->count();
        $data['count_draft'] = Article::when($userRole == 'guest', function($query) {
            return $query->where('creator', Auth::id());
        })->where('is_publish', '=' , '0')->count();
        $status = $request->status;
        if($request->status == 'all')
        {
           return redirect()->route('articles.index');
        } else {
            $data['article'] = Article::when($userRole == 'guest', function($query) {
                return $query->where('creator', Auth::id());
            })->where('is_publish', '=', $status)->paginate(5);
        }

        return view('back.article.index', $data, compact('status'));
    }

    public function selectSearch(Request $request)
    {
    	$category = [];

        if($request->has('q')){
            $search = $request->q;
            $category = Category_article::select("id", "nama")
            		->where('nama', 'LIKE', "%$search%")
            		->get();
        }
        return response()->json($category);
    }
    
    public function deleteAll(Request $request)
	{
		$id = $request->id;
		foreach ($id as $article) 
		{
			Article::where('id', $article)->delete()
            ? Alert::success('Suskes', 'Semua artikel yang dipilih berhasil dihapus!')
            : Alert::error('Error', 'Semua artikel yang dipilih gagal dihapus!');
		}
		return redirect()->back();
	}

    public function isPublish(Request $request, Article $article)
    {
        $data = [
            'judul' => $article->judul,
            'slug' => $article->slug,
            'gambar' => $article->gambar,
            'konten' => $article->konten,
            'tag' => $article->tag,
            'creator' => Auth::user()->id,
            'category' => $article->category,
            'is_publish' => $request->is_publish,
        ];

        if($article->update($data)) {
            if($article->is_publish == '1') {
                Alert::success('Suskes', 'Artikel telah berhasil dipublish!');
            } else {
                Alert::success('Suskes ', 'Artikel telah berhasil disimpan sebagai draf!');
            }
        } else {
            Alert::error('Error', 'Status artikel gagal diperbaharui!');
        }

        

        return redirect()->route('articles.index');
    }

    public function create()
    {
        $data['categories'] = Category_article::all();
        return view('back.article.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'judul' => 'required|unique:articles|min:20|max:150',
            'konten' => 'required|min:80',
            'category' => 'required',
            'gambar' => 'required',
        ],
        [
            'judul.required' => 'Kolom Judul harus di isi.',
            'judul.unique' => 'Judul sudah tersedia.',
            'judul.min' => 'minimal karakter yang dimasukan tidak boleh kurang dari 20 karakter.',
            'judul.max' => 'maksimal karakter tidak boleh lebih dari 70 karakter.',
            'konten.required' => 'Kolom Konten harus di isi.',
            'konten.min' => 'minimal karakter yang dimasukan tidak boleh kurang dari 80 karakter.',
            'category.required' => 'Kolom Kategori harus di isi.',
            'gambar.required' => 'Thumbnail untuk artikel harus ada.',
        ]);

        $gambar = ($request->gambar)
        ? $request->file('gambar')->store("/public/input/articles")
        : null;

        $data = [
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'gambar' => $gambar,
            'konten' => $request->konten,
            'tag' => $request->tag ? implode(',', $request->tag) : null,
            'creator' => Auth::user()->id,
            'category' => $request->category,
            'is_publish' => "1",
        ];

        Article::create($data)
        ? Alert::success('Suskes', 'Artikel telah berhasil dipublish!')
        : Alert::error('Error', 'Artikel gagal dipublish!');

        return redirect()->route('articles.index');
    }

    public function draf(Request $request)
    {  
        $request->validate([
            'judul' => 'required|unique:articles|min:20|max:150',
        ],
        [
            'judul.required' => 'Kolom Judul harus di isi.',
            'judul.unique' => 'Judul sudah tersedia.',
            'judul.min' => 'minimal karakter yang dimasukan tidak boleh kurang dari 20 karakter.',
            'judul.max' => 'maksimal karakter tidak boleh lebih dari 70 karakter.',
        ]);

        $gambar = ($request->gambar)
        ? $request->file('gambar')->store("/public/input/articles")
        : null;

        $data = [
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'gambar' => $gambar,
            'konten' => $request->konten,
            'tag' => $request->tag,
            'creator' => Auth::user()->id,
            'category' => $request->category,
        ];

        Article::create($data)
        ? Alert::success('Suskes', 'Artikel telah berhasil disimpan sebagai draf!')
        : Alert::error('Error', 'Artikel gagal disimpan sebagai draf!');

        return redirect()->route('articles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function preview($slug, Request $request) 
    {
        $data['widget_ads'] = Ad::where('status', '=', 'widget_ads')->first();
        $data['article'] = Article::where('slug', $slug)->first();
        $data['web'] = Web::find(1);
        $data['event_1'] = Article::where('selected_article', '=', 'event_1')->first();
        $data['event_2'] = Article::where('selected_article', '=', 'event_2')->first();
        return view('back.preview_articles', $data);
    }

    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['article'] = Article::findOrFail($id);
        $data['category'] = Category_article::all();
        return view('back.article.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'judul' => "required|unique:articles,judul,$article->id|min:20|max:150",
            'konten' => 'required|min:80',
            'category' => 'required',
            'gambar' => 'required'
        ],
        [
            'judul.required' => 'Kolom Judul harus di isi.',
            'judul.unique' => 'Judul sudah tersedia.',
            'judul.min' => 'minimal karakter yang dimasukan tidak boleh kurang dari 20 karakter.',
            'judul.max' => 'maksimal karakter tidak boleh lebih dari 70 karakter.',
            'konten.required' => 'Kolom Konten harus di isi.',
            'judul.min' => 'minimal karakter yang dimasukan tidak boleh kurang dari 80 karakter.',
            'category.required' => 'Kolom Kategori harus di isi.',
            'tag.required' => 'Kolom Tag harus di isi.',
            'gambar.required' => 'Thumbnail untuk artikel harus ada.'
        ]);

        if ($request->hasFile('gambar')) {
            if (Storage::exists($article->gambar) && !empty($article->gambar)) { 
                Storage::delete($article->gambar);
            }
            $gambar = $request->file('gambar')->store("/public/input/articles");
        }

        $data = [
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'gambar' => $request->hasFile('gambar') ? $gambar : $article->gambar,
            'konten' => $request->konten,
            'tag' => $request->tag ? implode(',', $request->tag) : $article->tag,
            'creator' => Auth::user()->id,
            'category' => $request->category,
            'is_publish' => "1",

        ];

        $article->update($data)
        ? Alert::success('Suskes', 'Artikel telah berhasil diperbaharui!')
        : Alert::error('Error', 'Artikel gagal diperbaharui!');

        return redirect()->route('articles.index');
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        foreach($article->comments as $comments) {
            $comments->delete();
        }

        foreach($article->visitors as $visitors) {
            $visitors->delete();
        }

        $article->delete()
            ? Alert::success('Sukses', "Article berhasil dihapus.")
            : Alert::error('Error', "Article gagal dihapus!");

        return redirect()->route('articles.index');
    }
}
