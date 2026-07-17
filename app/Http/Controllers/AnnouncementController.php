<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    /**
     * 一覧(全員) :固定を上に、その新しい順
     */
    public function index()
    {
        $announcements = Announcement::with('user')
            ->orderByDesc('is_pinned')
            ->latest()
            ->get();
        return view('announcements.index', compact('announcements'));
    }

    /**
     * 作成画面 (管理者)
     */
    public function create()
    {
        $this->authorize('create', Announcement::class);

        return view('announcements.create');
    }

    /**
     * 登録 (管理者)
     */
    public function store(Request $request)
    {
        $this->authorize('create', Announcement::class);

        $validated = $request->validate([
            'title'     => ['required', 'max:255'],
            'body'      => ['required'],
            'is_pinned' => ['boolean'],
        ]);

        $validated['user_id']   = Auth::id();
        $validated['is_pinned'] = $request->boolean('is_pinned');

        Announcement::create($validated);

        return redirect()->route('announcements.index')
            ->with('success', 'お知らせを投稿しました。');
    }

    /**
     * 詳細 (全員)
     */
    public function show(Announcement $announcement)
    {
        return view('announcements.show', compact('announcement'));
    }

    /**
     * 編集画面 (管理者)
     */
    public function edit(Announcement $announcement)
    {
        $this->authorize('update', $announcement);

        return view('announcements.edit', compact('announcement'));
    }

    /**
     * 更新 (管理者)
     */
    public function update(Request $request, Announcement $announcement)
    {
        $this->authorize('update', $announcement);

        $validated = $request->validate([
            'title'     => ['required', 'max:255'],
            'body'      => ['required'],
            'is_pinned' => ['boolean'],
        ]);

        $validated['is_pinned'] = $request->boolean('is_pinned');
        $announcement->update($validated);
        return redirect()->route('announcements.show', $announcement)
            ->with('success', 'お知らせを更新しました。');
    }

    /**
     * 削除
     */
    public function destroy(Announcement $announcement)
    {
        $this->authorize('delete', $announcement);
        $announcement->delete();
        return redirect()->route('announcements.index')
            ->with('success', 'お知らせを削除しました。');
    }
}
