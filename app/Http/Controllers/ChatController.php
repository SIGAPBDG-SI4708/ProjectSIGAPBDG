<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\ChatMessageSent;

class ChatController extends Controller
{
    public function getContacts()
    {
        $userId = Auth::id();

        $contactIds = ChatMessage::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->select('sender_id', 'receiver_id')
            ->get()
            ->flatMap(function ($msg) use ($userId) {
                return [$msg->sender_id, $msg->receiver_id];
            })
            ->reject(function ($id) use ($userId) {
                return $id == $userId;
            })
            ->unique();

        $contacts = User::whereIn('id', $contactIds)->with('daerah')->get()->map(function ($user) use ($userId) {
            $lastMessage = ChatMessage::where(function ($q) use ($userId, $user) {
                $q->where('sender_id', $userId)->where('receiver_id', $user->id);
            })->orWhere(function ($q) use ($userId, $user) {
                $q->where('sender_id', $user->id)->where('receiver_id', $userId);
            })->latest()->first();

            $unreadCount = ChatMessage::where('sender_id', $user->id)
                ->where('receiver_id', $userId)
                ->where('is_read', false)
                ->count();

            $user->last_message = $lastMessage;
            $user->unread_count = $unreadCount;
            return $user;
        })->sortByDesc(function ($user) {
            return $user->last_message ? $user->last_message->created_at : null;
        })->values();

        return response()->json($contacts);
    }

    public function searchUsers(Request $request)
    {
        $query = $request->input('q');
        $userId = Auth::id();

        if (empty($query)) {
            return response()->json([]);
        }

        $users = User::with('daerah')
            ->where('id', '!=', $userId)
            ->where(function ($q) use ($query) {
                $q->where('nama', 'like', "%{$query}%")
                    ->orWhere('role', 'like', "%{$query}%")
                    ->orWhereHas('daerah', function ($qDaerah) use ($query) {
                        $qDaerah->where('nama_daerah', 'like', "%{$query}%");
                    });
            })
            ->take(10)
            ->get();

        return response()->json($users);
    }

    public function getMessages($userId)
    {
        $myId = Auth::id();

        $messages = ChatMessage::with('sender')
            ->where(function ($q) use ($myId, $userId) {
                $q->where('sender_id', $myId)->where('receiver_id', $userId);
            })
            ->orWhere(function ($q) use ($myId, $userId) {
                $q->where('sender_id', $userId)->where('receiver_id', $myId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    public function sendMessage(Request $request, $userId)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $myId = Auth::id();

        $message = ChatMessage::create([
            'sender_id' => $myId,
            'receiver_id' => $userId,
            'message' => $request->input('message'),
            'is_read' => false
        ]);

        $receiver = User::find($userId);
        if ($receiver) {
            $receiver->notify(new \App\Notifications\ChatMasukNotification($message));
        }

        $message->load('sender');
        event(new ChatMessageSent($message));

        return response()->json($message);
    }

    public function markAsRead($userId)
    {
        $myId = Auth::id();

        $updated = ChatMessage::where('sender_id', $userId)
            ->where('receiver_id', $myId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        if ($updated > 0) {
            event(new \App\Events\ChatMessagesRead($myId, $userId));
        }

        $notifications = Auth::user()->notifications()->where('type', \App\Notifications\ChatMasukNotification::class)->get();
        foreach ($notifications as $notification) {
            if (isset($notification->data['sender_id']) && $notification->data['sender_id'] == $userId) {
                $notification->delete();
            }
        }

        return response()->json(['success' => true]);
    }
}
