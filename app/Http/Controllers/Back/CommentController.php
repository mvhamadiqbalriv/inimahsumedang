<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Reply;
use App\Models\Article;
use Alert;
use Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['comment'] = Comment::paginate(3, ['*'], 'all');
        $data['comment_approved'] = Comment::whereHas('replies', function($query) {
            $query->where('status', '=', 'approved');
        })->orWhere('status', '=', 'approved')->paginate(3, ['*'], 'approved');
        $data['comment_pending'] = Comment::whereHas('replies', function($query) {
            $query->where('status', '=', 'pending');
        })->orWhere('status', '=', 'pending')->paginate(3, ['*'], 'pending');
        $data['comment_trash'] = Comment::onlyTrashed()->paginate(3, ['*'], 'trash');
       
        return view('back.comment.index', $data);
    }

    public function commentReplies(Request $request) {
        $data = [
            'nama' => Auth::user()->name,
            'reply' => $request->reply,
            'email' => Auth::user()->email,
            'web' => $request->web,
            'comment' => $request->comment_id,
            'status' => 'pending'
        ];

        Reply::create($data)
        ? Alert::success('Berhasil', 'Balasan telah berhasil disimpan!')
        : Alert::error('Error', 'Balasan gagal di disimpan!');

        return redirect()->back();
    }

    public function replies(Request $request, Reply $reply) {

        $data = [
            'nama' => $reply->nama,
            'reply' => $reply->reply,
            'email' => $reply->email,
            'web' => $reply->web,
            'comment' => $request->comment_id,
            'status' => $request->status,
        ];

        $reply->update($data)
        ? Alert::success('Berhasil', 'Status Balasan telah berhasil diubah!')
        : Alert::error('Error', 'Status gagal diubah!');

        return redirect()->back();
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
        $data['comment'] = Comment::findOrFail($id);

        return view('back.comment.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $data = [
            'nama' => $comment->nama,
            'comment' => $comment->comment,
            'email' => $comment->email,
            'web' => $comment->web,
            'status' => $request->status
        ];

        $comment->update($data)
        ? Alert::success('Berhasil', 'Status komentar telah berhasil di perbaharui')
        : Alert::error('Error', 'Status komentar gagal di perbaharui');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);
        $comment->delete()
        ? Alert::success('Berhasil', 'Komentar telah berhasil di hapus')
        : Alert::error('Error', 'Komentar gagal di hapus');

        return redirect()->back();
    }

    public function destroy_permanently($id)
    {
        Reply::where('comment', $id)->delete();
        
        $commentDelete = Comment::onlyTrashed()->where('id', $id);
        $commentDelete->forceDelete()
        ? Alert::success('Berhasil', 'Komentar telah berhasil di hapus')
        : Alert::error('Error', 'Komentar gagal di hapus');

        return redirect()->back();
    }

    public function destroy_reply($id)
    {
        $reply = Reply::find($id);
        $reply->delete()
        ? Alert::success('Berhasil', 'Balasan telah berhasil di hapus')
        : Alert::error('Error', 'Balasan gagal di hapus');

        return redirect()->back();
    }

    public function commentRestore($id)
    {
        $restore = Comment::onlyTrashed()->where('id',$id);
        $restore->restore()
        ? Alert::success('Berhasil', 'Komentar telah berhasil di pulihkan')
        : Alert::error('Error', 'Komentar gagal di pulihkan');

        return redirect()->back();
    }
}
