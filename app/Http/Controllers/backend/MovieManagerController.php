<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
// use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;

class MovieManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.moviemanager');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function movieadd(Request $request)
    {
        //
        // $Data = $request->all();
        $filename = $_FILES['poster']['name'];
        echo $filename;
        echo '<br>';
        $file = $request->file('poster');
        echo 'File Name: ' . $file->getClientOriginalName();
        echo '<br>';
        //Display File Extension
        echo 'File Extension: ' . $file->getClientOriginalExtension();
        echo '<br>';

        //Display File Real Path
        echo 'File Real Path: ' . $file->getRealPath();
        echo '<br>';

        //Display File Size
        echo 'File Size: ' . $file->getSize();
        echo '<br>';

        //Display File Mime Type
        echo 'File Mime Type: ' . $file->getMimeType();
        // $data = $request->except('_token');
        // if ($request->file('photo')->isValid()) {
        //     //
        //     echo "失敗";
        //     exit;
        // }else{
        //     echo "成功";
        //     exit;
        // }
        $size = $request->file('poster');
        // $size = $request->hasFile('poster');
        dd( $file);
        // print_r($Data);
        exit;
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('backend.movieadd');
    }
}
