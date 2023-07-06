<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {

        $posts = request()->has(['page', 'limit']) ?

            Post::selectLatest()->get()->forPage(request('page'), request('limit')) :
            
            Post::selectLatest()->orderBy('id')->get();
        
        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     * @param \App\Http\Requests\StorePostRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePostRequest $request)
    {
        $attributes = $request->validated();
        $tmpFile = TemporaryFile::where("folder", $request->thumbnail)->first();
    
        if($attributes->fails() && $tmpFile) {
            Storage::deleteDirectory('posts/tmp/'. $tmpFile->folder);
            $tmpFile->delete();

            return response('false')->json([
                'message' => $attributes->errors()
            ]);
        }

        if($attributes->fails()) {
            return response()->json([
                'message' => $attributes->errors()
            ]);
        }

         if($tmpFile) {
            Storage::copy('posts/tmp/'. $tmpFile->folder . '/' . $tmpFile->file, 'posts/' . $tmpFile->folder . '/' . $tmpFile->file);
            $fileName = $tmpFile->folder . '/' . $tmpFile->file;

            Post::create([
                'user_id' => request()->user->id,
                'title' => $attributes['title'],
                'slug' => $attributes['slug'],
                'thumbnail' => $fileName,
                'content' => $attributes['content'],
                'is_published' => $attributes['is_published'],
                'excerpt' => $attributes['excerpt']
            ]);

            return response()->json([
                'message' => 'Post created successfully'
            ]);
        }

        return response()->json([
            'message' => $attributes->errors()
        ]);
    }

    /**
     * Display the specified resource.
     * @param \App\Models\Post $post
     * @return App\Http\Resources\PostResource
     */
    public function show(Post $post)
    {
        return new PostResource($post->loadMissing('author'));
    }

    /**
     * Update the specified resource in storage.
     * @param \App\Http\Requests\UpdatePostRequest $request
     * @param \App\Models\Post $post
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->validated());

        return response()->json([
            'message' => 'Post successfully updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param \App\Models\Post
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Post $post)
    {
        $post->delete();
        
        return response()->json([
            'message' => 'Post successfully deletec'
        ]);
    }

    /**
     * File Pond Temporary Storage
     * @param  \Illuminate\Http\Request  $request
     * @return  string
     */

    public function tmpUpload(Request $request): string {
        if($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $fileName = $image->getClientOriginalName();
            $folder = uniqid('posts', true);
            $image->storeAs('posts/tmp/'.$folder, $fileName);

            TemporaryFile::create([
                'folder' => $folder,
                'file' => $fileName
            ]);
            
            return response($folder);
        }
        return response('');
    }

    public function tmpDelete() {
        $tmpFile = TemporaryFile::where('folder', request()->getContent())->first();
        if($tmpFile) {
            Storage::deleteDirectory('posts/tmp/'. $tmpFile->folder);
            $tmpFile->delete();
            return response('');
        }
    }
}