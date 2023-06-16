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
            $posts = Post::where('is_published', false)->get();

            return $this->sendResponse($posts, 'success');

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
