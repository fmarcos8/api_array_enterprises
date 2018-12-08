<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\CommentsRequest as Request;
use Illuminate\Support\Facades\App;


class CommentsController extends Controller
{
    public function index()
    {
        return Comment::all();
    }

    public function store(Request $request)
    {
        return Comment::create($request->all());
    }

    public function show(Comment $comment)
    {
        return $comment;
    }

    public function update(Request $request, Comment $comment)
    {
        $comment->update($request->all());
        return $comment;
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return $comment;
    }
}
