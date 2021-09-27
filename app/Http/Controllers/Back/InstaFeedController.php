<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dymantic\InstagramFeed\Profile;
use App\Models\FeedToken;
use Alert;

class InstaFeedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['instafeed'] = Profile::all();
       
        return view('back.instafeed.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function checkUsername(Request $request) 
    {
        if($request->Input('username')){
            $username = Profile::where('username',$request->Input('username'))->first();
            if($username){
                return 'false';
            }else{
                return  'true';
            }
        }
    }

    public function complete() {
        $data['instafeed'] = Profile::all();
        $data['was_successful'] = request('result') === 'success';
    
        return view('back.instafeed.index', $data);
    }

    public function getFeed(Request $request)
    {
        $profile = Profile::where('username', $request->username)->first();
        $profile->refreshFeed(6)
        ? Alert::success('Berhasil', "Feed telah berhasil diambil!")
        : Alert::error('Error', "Feed gagal diambil!");

        return redirect()->back();
    }

    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Profile::create(['username' => $request->username])
        ? Alert::success('Berhasil', "Username telah berhasil ditambahkan!")
        : Alert::error('Error', "Username gagal ditambahkan!");

        return redirect()->back();
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
        $feedToken = FeedToken::all();
        foreach($feedToken as $feedTokens)
        {
            $feedTokens->delete();
        }
        $profile = Profile::findOrFail($id);
        $profile->delete()
        ? Alert::success('Berhasil', "Username telah berhasil dihapus!")
        : Alert::error('Error', "Username gagal dihapus!");

        return redirect()->back();
    }
}
