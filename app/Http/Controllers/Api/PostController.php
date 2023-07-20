<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends BaseController
{
    public $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }
    /**
     * Display a listing of the published posts for all users or login user depending on filter param in request.
     */
    public function published_posts(Request $request)
    {

        $posts = $this->postService->published_posts($request);

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
        $data = $this->postService->create($request);

        if(! $data){
            return $this->sendError('!! Ops some thing went wrong','',500);
        }

        return $this->sendResponse('success', 'Post Created Successfully.');
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
