<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentsResource;
use App\Models\Comment;
use App\Http\Requests\CommentsRequest as Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;


class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index']);
    }

    public function index()
    {
        return CommentsResource::collection(Comment::orderBy('id', 'desc')->paginate(10));
    }

    public function store(Request $request)
    {
        $comment = new Comment($request->all());
        $comment->save();

        if (!$comment) {
            abort(500, 'Server Error!');
        }

        return response()->json([
            'status' => 'success',
            'data' => new CommentsResource($comment)
        ], 200);
    }

    public function show($id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            abort(404, 'Comment not found');
        }

        $result = new CommentsResource($comment);

        return response()->json([
            'data' => $result
        ]);
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            abort(400, 'Not Found');
        }

        if (Auth::user()->id != $comment->id_user) {
            abort(403, 'You can only edit your own books.');
        }

        $comment->fill($request->all());
        $comment->save();

        return response()->json([
            'data' => $comment,
            'message' => 'Comment Updated'
        ], 200);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return $comment;
    }
}
