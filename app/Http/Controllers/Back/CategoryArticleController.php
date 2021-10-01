<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category_article;
use App\Models\Article;
use DataTables;
use Str;
use Alert;

class CategoryArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['category'] = Category_article::all();

        return view('back.category_article.index',$data);
    }

    public function checkCategory(Request $request) 
    {
        if($request->Input('nama')){
            $nama = Category_article::where('nama',$request->Input('nama'))->first();
            if($nama){
                return 'false';
            }else{
                return  'true';
            }
        }

        if($request->Input('edit_nama')){
            $edit_nama = Category_article::where('nama',$request->Input('edit_nama'))->first();
            if($edit_nama){
                return 'false';
            }else{
                return  'true';
            }
        }
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
        $request->validate([
            'nama' => 'required|unique:category_articles',
        ]);

        $data = [
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'category_icon' => $request->category_icon
        ];

        Category_article::create($data)
        ? Alert::success('Sukses', 'Category telah berhasil dibuat')
        : Alert::error('Error', 'Category gagal dibuat');

        return redirect()->route('category-articles.index');
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
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category_article $Category_article)
    {   
        $request->validate([
            'edit_nama' => "required|min:3|unique:category_articles,nama,$Category_article->id|max:35",
        ]);

        $data = [
            'nama' => $request->edit_nama,
            'slug' => Str::slug($request->edit_nama),
            'category_icon' => $request->edit_category_icon
        ];

        $Category_article->update($data)
        ? Alert::success('Sukses', "Category berhasil diubah.")
        : Alert::error('Error', "Category gagal diubah!");

        return redirect()->route('category-articles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category_article = Category_article::find($id);
    	$category_article->delete()
            ? Alert::success('Sukses', "Category berhasil dihapus.")
            : Alert::error('Error', "Category gagal dihapus!");

        return redirect()->route('category-articles.index');
    }
}
