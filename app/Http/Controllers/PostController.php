<?php

namespace App\Http\Controllers;

use App\Helpers\Pagination;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostTutors;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        self::hasRole(Config::get('constants.role.slug_tutor.slug'));
        return view('post.index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function  getPost(Request $request)
    {
        self::hasRole(Config::get('constants.role.slug_tutor.slug'));
        $query = Post::query()->select('post.*','sub_category.name as sub_category_name','category.name as category_name')
            ->leftJoin('sub_category', 'sub_category.id', '=', 'post.sub_category_id')
            ->leftJoin('category', 'category.id', '=', 'sub_category.category_id')
            ->where('post.user_id',Auth::id())
        ;
        return Pagination::preparePagination($query,$request,['post.name','sub_category.name','category.name','post.description']);
    }
    /**
     * Return dropdown values.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getReference(Request $request){
        $reference = [
            "category"  => Category::with('subCategory')->get(),
            "tutors"    => User::whereNotNull('razorpay_id')->whereNotIn('id',[Auth::id()])->whereHas('roles', function($q){$q->where('name', Config::get('constants.role.slug_tutor.slug'));})->get(),

        ];
        return $reference;
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
     * Store a newly created resource in post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|unique:post,name',
            'sub_category_id'  => 'required|numeric',
            'amount'  => 'required|numeric|gt:0|regex:/^\d+(\.\d{1,2})?$/',
            'post_pdf_id'  => 'required|numeric',
            'post_tutors.*.tutor_id' => 'required|numeric',
            'post_tutors.*.amount' => 'required|numeric|gt:0|regex:/^\d+(\.\d{1,2})?$/',
        ]);
        $message = DB::transaction(function() use ($request) {
            $data = $request->all();
            $data['user_id'] = Auth()->user()->id;
            $post =  Post::create($data);
            if( isset($data['post_tutors']) && count($data['post_tutors']) > 0 ){
                foreach ($data['post_tutors'] as $key => $item ){
                    $item['post_id'] = $post->id;
                    PostTutors::create($item);
                }
            }
            return $post['name']." post has been created";
        });
        return response()->json($message, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post->postTutors;
        $post->frontImage;
        $post->postPdf;
        $post->subCategory;
        return $post;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'name'  => 'required|unique:post,name,'.$post['id'],
            'sub_category_id'  => 'required|numeric',
            'amount'  => 'required|numeric|gt:0|regex:/^\d+(\.\d{1,2})?$/',
            'post_pdf_id'  => 'required|numeric',
            'post_tutors.*.tutor_id' => 'required|numeric',
            'post_tutors.*.amount' => 'required|numeric|gt:0|regex:/^\d+(\.\d{1,2})?$/',
        ]);
        $message = DB::transaction(function() use ($request,$post) {
            $data = $request->all();
            $post->update($data);
            if( isset($data['post_tutors']) && count($data['post_tutors']) > 0 ){
                foreach ($data['post_tutors'] as $key => $item ){
                    $item['post_id'] = $post->id;
                    if( isset($item['id']) && !is_null($item['id']) ){
                        $postTutor = PostTutors::findOrFail($item['id']);
                        $postTutor->update($item);
                    }else{
                        PostTutors::create($item);
                    }
                }
            }
            return $post['name']." post has been updated";
        });
        return response()->json($message, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
    public function deletePostTutor(Request $request,$id){
        $postTutors = PostTutors::findOrFail($id);
        if($postTutors->delete()){
            return response()->json([], 201);
        }
        return response()->json([], 501);
    }
}
