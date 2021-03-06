<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['list'] = Permission::all();
        return view('back.permission',$data);
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
            'name' => 'required|max:50|unique:permissions'
        ]);

        $new = new Permission([
            'name' => $request->post('name'),
            'guard_name' => 'web'
        ]);

        if ($new->save()) {
            return response()->json([
                'status' => 'Success',
                'data' => $new
            ], 200);
        }else{
            return response()->json([
                'status' => 'Error'
            ], 404);

        }
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
        $request->validate([
            'name' => 'required|max:50|unique:permissions,name,'.$id
        ]);

        $update = Permission::findOrFail($id);
        $update->name = $request->name;

        if ($update->save()) {
            return response()->json([
                'status' => 'Success',
                'data' => $update
            ], 200);
        }else{
            return response()->json([
                'status' => 'Error'
            ], 404);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Permission::findOrFail($id);

        if ($delete->delete()) {
            return response()->json([
                'status' => 'Success',
            ], 200);
        }else{
            return response()->json([
                'status' => 'Error'
            ], 404);

        }
    }
}
