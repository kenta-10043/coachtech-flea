<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    public function store(CommentRequest $request, $item_id)
    {
        $comment = [
            'item_id' => $item_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ];
        Comment::create($comment);

        return redirect()->route('item.show', ['item_id' => $item_id])->with('success', 'コメントを投稿しました');
    }
}
