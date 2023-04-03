<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Resources\PostResource;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest()
                    ->paginate(10);

        return PostResource::collection($posts); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $attributes = $request->validated();

        $posts = Post::create([
            'user_id' => request()->user->id,
            'title' => $attributes['title'],
            'slug' => $attributes['slug'],
            'thumbnail' => $attributes['thumbnail'],
            'content' => $attributes['content'],
            'is_published' => $attributes['is_published'],
            'excerpt' => $attributes['excerpt']
        ]);

        return $posts ? 
            response()->json(['response' => true]) :
            response()->json(['response' => false]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return new PostResource($post->loadMissing('author'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        if($post->update($request->validated()))
            return response()->json(["response" => true]);
        else 
            return response()->json(["response" => false]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if($post->delete())
            return response()->json(["response" => true]);
        else
            return response()->json(["response" => false]);
    }
}