<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\helperTrait\apiResponse;
use App\Models\post;
use Illuminate\Http\Request;

class postController extends Controller
{

    use apiResponse;

    public function __construct()
    {
        $this->middleware('auth:api',['except'=>['index']]);  //all secret but login is public
    }

    //all posts
    public function index(){

        $posts = post::all();

        return $this->TheResponse($posts,200,'success');

    }


    // show post by id
    public function show(Request $request){


        $post = post::find($request->id);

        if($post){
            return $this->TheResponse($post,200,'success');
        }else{
            return $this->TheResponse(null,404,'not found');
        }

    }

    //add post
    public function store(Request $request){

        $validator = validator($request->all(),[
            'post_name'=>'required|max:30',
            'post_content'=>'required'
        ]);


        if($validator->fails()){
            return $this->TheResponse(null,400,$validator->errors()->toJson());

        }else{

            $post = post::create($request->all());

            return $this->TheResponse($post,200,'added successfully');
        }



    }

    //update post
    public function update(Request $request){

        $validator = validator($request->all(),[
            'post_name'=>'required|max:30',
            'post_content'=>'required'
        ]);


        if($validator->fails()){
            return $this->TheResponse(null,400,$validator->errors()->toJson());

        }else {

            $post = post::find($request->id);

            if ($post) {
                $post->update($request->all());

                return $this->TheResponse($post, 200, 'success');
            } else {
                return $this->TheResponse(null, 404, 'not found');

            }

        }
    }

    //delete post
    public function delete(Request $request){

        $post = post::find($request->id);


        if($post){
            $postDelete = $post->delete();
            return $this->TheResponse(null,200,'deleted successfully');
        }else{

            return $this->TheResponse(null, 404, 'not found');

        }
    }
}
