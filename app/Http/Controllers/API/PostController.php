<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        $data = $posts->toArray();

        $response =[
            'success'=> true,
            'data' => $data,
            'message' => 'Posts Listed Successfuly'
        ];

        return response()->json($response,200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        
        $validator = Validator:: make($input, [
            'title'=>'required',
            'body'=>'required'
        ]);

        if ($validator->fails()){
            $response =[
                'success'=> false,
                'data' =>'Validation Error',
                'message' => $validator->errors()
            ];
            return response()->json($response,404);
        }
        $post = Post::create($input);

        $data = $post->toArray();

        $response = [
            'success'=> true,
            'data' =>$data,
            'message' => 'Post Created Successfully'
        ];
        return response()->json($response,202);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        $data = $post->toArray();

        if(is_null($post)){
            $response = [
            'success' => false,
            'data' => 'Empty Post',
            'message' => 'Post Not Found'
            ];

            return response()->json($response,400);
        }
        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Post Retrieved Successfully'
            ];

            return response()->json($response,200);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Post $post)
    {
        $input = $request->all();
        
        $validator = Validator:: make($input, [
            'title'=>'required',
            'body'=>'required'
        ]);

        if ($validator->fails()){
            $response =[
                'success'=> false,
                'data' =>'Validation Error',
                'message' => $validator->errors()
            ];
            return response()->json($response,404);
        }
        $post->title = $input['title'];
        $post->body = $input['body'];

        $post->save();

        $data = $post->toArray();

        $response = [
            'success'=> true,
            'data' =>$data,
            'message' => 'Post Updated Successfully'
        ];
        return response()->json($response,202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post ->delete();

        $data = $post->toArray();

        $response = [
            'success'=> true,
            'data' =>$data,
            'message' => 'Post Deleted Successfully'
        ];
        
        return response()->json($response,202);
    }
}
