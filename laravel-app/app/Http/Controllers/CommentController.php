<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $comment = new Comment;
        $comment->body = $request->get('comment_body');
        $comment->user()->associate($request->user());
        $comment->is_parent = 1;
        $comment->post_id = $request->get('post_id');
        $comment->save();


        return back();
    }

    public function replyStore(Request $request)
    {
        $reply = new Comment();
        $reply->body = $request->get('comment_body');
        $reply->user()->associate($request->user());
        $reply->post_id = $request->get('post_id');
        $reply->save();
        $reply->replies()->sync([$reply->id => ['comment_id' => $request->get('comment_id')]]);

        return back();
    }

    public function destroy(Comment $comment)
    {
        $replies = $comment->replies()->get();
        \Log::info(['REPLIES' => $replies]);
        \Log::info(__FILE__ . ' on line: ' . __LINE__);
        foreach ($replies as $reply) {
//            $reply->detach();
            $reply->delete();
        }
        return back();
    }


}
