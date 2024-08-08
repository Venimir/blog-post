<?php

namespace App\Http\Controllers;

use App\DataTables\PostDataTable;
use App\Http\Requests\StorePostRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(PostDataTable $dataTable)
    {
        return $dataTable->render('index');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function create()
    {
        if (!auth()->user()->can('create_posts')) {
            abort(403);
        }

        return view('post');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StorePostRequest $request)
    {
        if (!Gate::allows('create_posts')) {
            abort(403);
        }

        Post::create($request->validated());

        return redirect('posts');
    }

    public function show(Post $post)
    {
        return view('edit', compact('post'));
    }

    public function destroy(Post $post)
    {
        if (!Gate::allows('delete_posts')) {
            abort(403);
        }

        $post->delete();

        return back();
    }
}
