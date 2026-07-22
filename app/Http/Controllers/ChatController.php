<?php

namespace App\Http\Controllers;

use App\Models\DirectMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     *  社員一覧(チャット相手を選ぶ画面)
     */
    public function index()
    {
        $myId = Auth::id();

        // 自分以外の社員
        $users = User::where('id', '!=', $myId)
            ->orderBy('name')
            ->get();

        // 相手ごとの未読件数
        $unreadCounts = DirectMessage::where('receiver_id', $myId)
            ->whereNull('read_at')
            ->selectRaw('sender_id, count(*) as total')
            ->groupBy('sender_id')
            ->pluck('total', 'sender_id');

        // 相手ごとの最新メッセージ
        $latestMessages = DirectMessage::where('sender_id', $myId)
            ->orWhere('receiver_id', $myId)
            ->latest()
            ->get()
            ->groupBy(function ($message) use ($myId) {
                return $message->sender_id === $myId
                    ? $message->receiver_id
                    : $message->sender_id;
            })
            ->map(function ($group) {
                return $group->first();
            });

        return view('chats.index', compact('users', 'unreadCounts', 'latestMessages'));
    }

    /**
     *  特定の相手とのチャット画面
     */
    public function show(User $user)
    {
        $myId = Auth::id();

        // 自分自身とはチャットできない
        abort_if($user->id === $myId, 403);

        // 2人の間のメッセージをい時系列で取得
        $messages = DirectMessage::where(function ($query) use ($myId, $user) {
            $query->where('sender_id', $myId)
                ->where('receiver_id', $user->id);
        })
            ->orWhere(function ($query) use ($myId, $user) {
                $query->where('sender_id', $user->id)
                    ->where('receiver_id', $myId);
            })
            ->oldest()
            ->get();
        
        // 相手からの未読を既読にする
        DirectMessage::where('sender_id', $user->id)
            ->where('receiver_id', $myId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('chats.show', compact('user', 'messages'));
    }

    /**
     *  メッセージ送信
     */
    public function store(Request $request, User $user)
    {
        abort_if($user->id === Auth::id(), 403);

        $validated = $request->validate([
            'body' => ['required', 'max:1000'],
        ]);

        DirectMessage::create([
            'sender_id'     => Auth::id(),
            'receiver_id'   => $user->id,
            'body'          => $validated['body'],
        ]);

        return redirect()->route('chats.show', $user);
    }
}
