<?php

namespace App\Services;

use App\Models\Post;

class PostService
{
    public function published_posts($request)
    {
        $posts =  Post::where('is_published', true)->get();

        if($request->filter == 'me'){

           $posts = $posts->where('user_id', $request->user()->id)->toArray();

        }

        return $posts;
    }

    public function create($request)
    {
       $data = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => $request->user()->id,
        ]);

        return $data;

    }
}