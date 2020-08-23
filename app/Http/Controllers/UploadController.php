<?php

namespace App\Http\Controllers;

use App\Models\Uploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class UploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\Uploads  $uploads
     * @return \Illuminate\Http\Response
     */
    public function show(Uploads $uploads)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Uploads  $uploads
     * @return \Illuminate\Http\Response
     */
    public function edit(Uploads $uploads)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Uploads  $uploads
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Uploads $uploads)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Uploads  $uploads
     * @return \Illuminate\Http\Response
     */
    public function destroy(Uploads $uploads)
    {
        Storage::delete($uploads->uploaded_path);
        $uploads->delete();
        return response()->json("Deleted successfully",200);
    }
    public function upload(Request $request){
        $data = $request->all();
        $uploadedPath = $request->attachment->store(Config::get('constants.upload_path'));
        $uploadData = [
            "uploaded_path" => $uploadedPath,
            "file_name"     =>  $data["attachment"]->getClientOriginalName(),
            "file_size"     =>  $data["attachment"]->getSize(),
            "user_id"        =>  Auth()->user()->id
        ];
        $upload = Uploads::create($uploadData);
        if( $upload )
            return response()->json($upload, 200);
        return response()->json('', 500);
    }
    /*public function delete(Request $request){
        $uploadData = (array)json_decode($request->getContent());
        print_r($uploadData);exit;
        if( isset($uploadData['id']) ){
            $upload = Uploads::findOrFail($uploadData['id']);
            Storage::delete($upload->uploaded_path);
            $upload->delete();
            return response()->json("Deleted successfully",200);
        }
        return response()->json("File id does not exit's",501);
    }*/
}
