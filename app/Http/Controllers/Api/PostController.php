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

        $posts =  Post::where('is_published', true)->get();

        if($request->filter == 'me'){

           $posts = $posts->where('user_id', Auth::user()->id)->toArray();

        }

        return $this->sendResponse($posts, 'success');

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
        return Auth::user();

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
    public function post_publish_or_delete($id, Request $request)
    {
            if($request->status == 1){
               $post = Post::findOrFail($id);
               $post->update([
                'is_published' => true,
               ]);
               
               return $this->sendResponse('post published successfully', 'published');
            }else{
                
                $post = Post::findOrFail($request->id);
                $post->delete();

                return $this->sendResponse('post deleted successfully', 'deleted');
            }

    }


}
