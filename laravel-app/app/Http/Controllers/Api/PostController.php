<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
       $posts = Post::all();

       if (is_null($posts)) {
           return response()->json([
               'status'  => 'failed',
               'message' => 'No post found.',
           ], 200);
       }
           $response = [
               'status' => 'success',
               'message' => 'Posts are retrieved successfully.',
               'data' => $posts,
           ];

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($post)
    {

        if (is_null($post)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Product is not found!',
            ], 200);
        }

        $response = [
            'status' => 'success',
            'message' => 'Post is retrieved successfully.',
            'data' => $post,
        ];

        return response()->json($response, 200);
    }
}
