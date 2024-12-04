<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $event_id)
    {
        // Validate input
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        // Save the comment
        Comment::create([
            'user_id' => auth()->id(),
            'event_id' => $event_id,
            'content' => $request->input('content'),
        ]);

        return redirect()->back()->with('success', 'Comment added successfully!');
    }

    public function destroy(Comment $comment)
    {
        $user = Auth::user();

        // Admin can delete any comment
        if ($user->role === 'admin') {
            $comment->delete();
            return redirect()->back()->with('success', 'Comment deleted successfully.');
        }

        // Vendor can delete comments on their own events
        if (
            $user->role === 'vendor' && 
            $comment->event && 
            $comment->event->created_by === $user->id
        ) {
            $comment->delete();
            return redirect()->back()->with('success', 'Comment deleted successfully.');
        }

        // User can delete their own comments
        if ($user->id === $comment->user_id) {
            $comment->delete();
            return redirect()->back()->with('success', 'Comment deleted successfully.');
        }

        return redirect()->back()->with('error', 'You do not have permission to delete this comment.');
    }

    public function index($event_id)
    {
        $comments = Comment::where('event_id', $event_id)->get();
        $user = Auth::user();

        return view('comments.index', [
            'comments' => $comments,
            'user' => $user,
        ]);
    }
}
