<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PostResource;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(PostResource::collection(Post::all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'place_id' => 'required|integer|exists:places,id',
            'title' => 'required|string',
            'description' => 'required|string',
            'img_url' => 'required|image',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);
        if ($validator->fails()){return response()->json($validator->errors(), 400);}

        $post = Post::create([
            'user_id' => $request->user()->id,
            'place_id' => (integer) $request->place_id,
            'title' => $request->title,
            'description' => $request->description,
            'img_url' => $request->img_url->store('/images/post', 'attachment'),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);

        return response()->json(new PostResource($post));
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

        if (isset($post))
        {
            return response()->json(new PostResource($post));
        }
        else
        {
            return response()->json([
                'result' => 'error',
                'message' => 'Not found.'
            ],404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'place_id' => 'required|integer|exists:places,id',
            'title' => 'required|string',
            'description' => 'required|string',
            'img_url' => 'image',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);
        if ($validator->fails()){return response()->json($validator->errors(), 400);}

        $post = Post::find($id);
        $post->update([
            'place_id' => $request->place_id,
            'title' => $request->title,
            'description' => $request->description,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);

        if ($request->has('img_url'))
        {
            if (isset($post->img_url))
            {
                Storage::disk('attachment')->delete($post->img_url);
            }
            $post->img_url = $request->img_url->store('/images/post', 'attachment');
            $post->saveOrFail();
        }

        return response()->json(new PostResource($post));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if (isset($post))
        {
            Storage::disk('attachment')->delete($post->img_url);
            $post->delete();

            return response()->json(null,204);
        }
        else
        {
            return response()->json([
                'result' => 'error',
                'message' => 'Not found.'
            ],404);
        }
    }
}
