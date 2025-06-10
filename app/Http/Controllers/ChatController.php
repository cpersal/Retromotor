<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $chats = Message::where('sender_id', Auth::id())
            ->orWhere('receiver_id', Auth::id())
            ->with(['sender', 'receiver'])
            ->latest()
            ->get()
            ->unique(function ($message) {
                return $message->sender_id < $message->receiver_id
                    ? $message->sender_id . '-' . $message->receiver_id
                    : $message->receiver_id . '-' . $message->sender_id;
            })
            ->map(function ($message) {
                $otherUser = $message->sender_id == Auth::id()
                    ? $message->receiver
                    : $message->sender;

                $lastMessage = Message::where(function ($query) use ($otherUser) {
                    $query->where('sender_id', Auth::id())
                        ->where('receiver_id', $otherUser->id);
                })->orWhere(function ($query) use ($otherUser) {
                    $query->where('sender_id', $otherUser->id)
                        ->where('receiver_id', Auth::id());
                })->latest()->first();

                $unreadCount = Message::where('sender_id', $otherUser->id)
                    ->where('receiver_id', Auth::id())
                    ->where('is_read', false)
                    ->count();

                return (object) [
                    'otherUser' => $otherUser,
                    'lastMessage' => $lastMessage,
                    'unread_count' => $unreadCount
                ];
            });

        return view('chat.index', compact('chats'));
    }

    public function show(User $user)
    {
        if (Auth::id() === $user->id) {
            return redirect()->route('chat.index')->with('error', 'No puedes chatear contigo mismo');
        }

        $messages = Message::where(function ($query) use ($user) {
            $query->where('sender_id', Auth::id())
                ->where('receiver_id', $user->id);
        })->orWhere(function ($query) use ($user) {
            $query->where('sender_id', $user->id)
                ->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        Message::where('sender_id', $user->id)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('chat.show', compact('user', 'messages'));
    }

    public function store(Request $request, User $user)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'content' => $request->content,
        ]);

        $message->load('sender');

        return response()->json([
            'id' => $message->id,
            'content' => $message->content,
            'sender_id' => $message->sender_id,
            'sender_name' => $message->sender->name,
            'created_at' => $message->created_at->format('H:i'),
        ]);
    }

    public function getNewMessages(User $user)
    {
        $messages = Message::where('sender_id', $user->id)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->orderBy('created_at', 'asc')
            ->get();

        if ($messages->isNotEmpty()) {
            Message::where('sender_id', $user->id)
                ->where('receiver_id', Auth::id())
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }

        return response()->json($messages->load('sender'));
    }
}
