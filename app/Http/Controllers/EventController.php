<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * 一覧 (全員) :開催日が近い順
     */
    public function index()
    {
        $events = Event::withCount('participants')
            ->orderBy('held_at')
            ->get();

        return view('events.index', compact('events'));
    }

    /**
     * 詳細 (全員)
     */
    public function show(Event $event)
    {
        $event->load('participants');

        // 自分が参加済みか
        $isJoined = $event->participants->contains(Auth::id());

        return view('events.show', compact('event', 'isJoined'));
    }

    /**
     * 作成画面 (管理者)
     */
    public function create()
    {
        $this->authorize('create', Event::class);

        return view('events.create');
    }

    /**
     * 登録 (管理者)
     */
    public function store(Request $request)
    {
        $this->authorize('create', Event::class);

        $validated = $request->validate([
            'title'     => ['required', 'max:255'],
            'body'      => ['required'],
            'held_at'   => ['required', 'date'],
        ]);

        $validated['user_id'] = Auth::id();

        Event::create($validated);

        return redirect()->route('events.index')
            ->with('success', 'イベントを作成しました。');
    }


    /**
     * 編集画面 (管理者)
     */
    public function edit(Event $event)
    {
        $this->authorize('update', $event);

        return view('events.edit', compact('event'));
    }

    /**
     * 更新 (管理者)
     */
    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        $validated = $request->validate([
            'title'     => ['required', 'max:255'],
            'body'      => ['required'],
            'held_at'   => ['required', 'date'],
        ]);

        $event->update($validated);

        return redirect()->route('events.show', $event)
            ->with('success', 'イベントを更新しました。');
    }

    /**
     * 削除 (管理者)
     */
    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);

        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'イベントを削除しました。');
    }

    // 参加/不参加の切り替え(全員)
    public function toggleJoin(Event $event)
    {
        Auth::user()->joinedEvents()->toggle($event->id);

        return back();
    }
}
