<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function posts(Request $request)
    {
        if($request->filter == 'me'){

            $posts =  Post::where('is_published', true)->where('user_id', Auth::user()->id)->get();

            return $this->sendResponse($posts, 'success');

        }else{
            $posts =  Post::where('is_published', true)->get();

            return $this->sendResponse($posts, 'success');

        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function unpublished_posts()
    {
        if(Auth::user()->is_admin){
            $posts = Post::where('is_published', false)->get();

            return $this->sendResponse($posts, 'success');
        }

        return $this->sendError('Not allowed');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {

        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::user()->id,
        ]);

        return $this->sendResponse('post added successfully.', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function post_publish(Request $request)
    {
        if(Auth::user()->is_admin){

            if($request->status == 1){
               $post = Post::where('id', $request->id)->first();
                if(!$post){
                    return $this->sendError('not found');
                }
               $post->update([
                'is_published' => true,
               ]);
               
               return $this->sendResponse('post published successfully', 'published');
            }else{
                $post = Post::where('id', $request->id)->first();

                if(!$post){
                    return $this->sendError('not found');
                }
                $post->delete();

                return $this->sendResponse('post deleted successfully', 'deleted');
            }

        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
