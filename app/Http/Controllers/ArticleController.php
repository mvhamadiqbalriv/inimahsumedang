<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category_article;
use Alert;
use Auth;
use Str;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['article'] = Article::all();
        $data['count_all'] = Article::all()->count();
        $data['count_published'] = Article::where('is_publish', '=' , '1')->count();
        $data['count_draft'] = Article::where('is_publish', '=' , '0')->count();
        return view('back.article.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

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
			Article::where('id', $article)->delete();
		}
		return redirect()->back();
	}

    public function publikasi(Request $request)
	{
		$id = $request->id;
		foreach ($id as $article) 
		{
			Article::where('id', $article)->delete();
		}
		return redirect()->back();
	}


    public function create()
    {
        return view('back.article.create');
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
            'judul' => 'required',
            'gambar' => 'required',
            'konten' => 'required',
            'category' => 'required',
            'tag' => 'required',
        ],
        [
            'judul.required' => 'Kolom Judul harus di isi.',
            'konten.required' => 'Kolom Konten harus di isi.',
            'category.required' => 'Kolom Kategori harus di isi.',
            'tag.required' => 'Kolom Tag harus di isi.',
        ]);

        $data = [
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'gambar' => $request->gambar,
            'konten' => $request->konten,
            'tag' => $request->tag,
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
        $data = [
            'judul' => $request->judul,
            'slug' => $request->slug,
            'gambar' => $request->gambar,
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
        $data['article'] = Article::findOrFail($id);
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
            'judul' => 'required',
            'gambar' => 'required',
            'konten' => 'required',
            'tag' => 'required',
            'category' => 'required',
        ],
        [
            'judul.required' => 'Kolom Judul harus di isi.',
            'konten.required' => 'Kolom Konten harus di isi.',
            'category.required' => 'Kolom Kategori harus di isi.',
            'tag.required' => 'Kolom Tag harus di isi.',
        ]);

        $data = [
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'gambar' => $request->gambar,
            'konten' => $request->konten,
            'tag' => $request->tag,
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
    public function destroy(Article $Article)
    {
        $Article->delete()
            ? Alert::success('Sukses', "Article berhasil dihapus.")
            : Alert::error('Error', "Article gagal dihapus!");

        return redirect()->route('articles.index');
    }
}
