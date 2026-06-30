<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get all conversations for this user (either as buyer or seller)
        $conversations = Conversation::where('buyer_id', $user->id)
            ->orWhere('seller_id', $user->id)
            ->with(['buyer', 'seller', 'messages' => function ($query) {
                $query->latest()->limit(1); // Get the latest message for preview
            }])
            ->get()
            ->sortByDesc(function ($conv) {
                return $conv->messages->first() ? $conv->messages->first()->created_at : $conv->created_at;
            });

        return view('chat.index', compact('conversations'));
    }

    public function startConversation(User $seller)
    {
        $buyer = auth()->user();

        if ($buyer->id === $seller->id) {
            return redirect()->back()->with('error', 'Anda tidak dapat mengirim pesan ke diri sendiri.');
        }

        // Find existing conversation or create a new one
        $conversation = Conversation::firstOrCreate([
            'buyer_id' => $buyer->id,
            'seller_id' => $seller->id,
        ]);

        return redirect()->route('chat.index', ['conversation' => $conversation->id]);
    }

    public function fetchMessages(Conversation $conversation)
    {
        // Ensure user belongs to conversation
        if (auth()->id() !== $conversation->buyer_id && auth()->id() !== $conversation->seller_id) {
            abort(403);
        }

        $messages = $conversation->messages()->with('sender')->get();

        // Mark unread messages as read
        $conversation->messages()
            ->where('sender_id', '!=', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json($messages);
    }

    public function store(Request $request, Conversation $conversation)
    {
        // Ensure user belongs to conversation
        if (auth()->id() !== $conversation->buyer_id && auth()->id() !== $conversation->seller_id) {
            abort(403);
        }

        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $message = $conversation->messages()->create([
            'sender_id' => auth()->id(),
            'message' => $request->message,
            'is_read' => false
        ]);

        return response()->json($message->load('sender'));
    }
}
