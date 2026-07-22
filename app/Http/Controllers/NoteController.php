<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * 一覧(タグで絞り込み可)
     */
    public function index()
    {
        $tagId = $request->input('tag_id');

        $notes = Note::where('user_id', Auth::id())
            ->with('tags')
            ->when($tagId, function ($query, $tagId) {
                $query->whereHas('tags', function ($q) use ($tagId) {
                    $q->where('tags.id', $tagId);
                });
            })
            ->latest()
            ->get();

        // 絞り込み用に自分のタグ一覧
        $tags = Tag::where('user_id', Auth::id())->orderBy('name')->get();

        return view('notes.index', compact('notes', 'tags', 'tagId'));
    }

    /**
     * 詳細
     */
    public function show(Note $note)
    {
        $this->authorizeNote($note);
        $note->load('tags');
        return view('notes.show', compact('note'));
    }

    /**
     * 作成画面
     */
    public function create()
    {
        return view('notes.create');
    }

    /**
     * 登録
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'max:255'],
            'body'  => ['nullable'],
            'tags'  => ['nullable', 'string', 'max:255'],
        ]);

        $note = Note::create([
            'user_id' => Auth::id(),
            'title'   => $validated['title'],
            'body'    => $validated['body'] ?? null,
        ]);

        $this->syncTags($note, $validated['tags'] ?? '');

        return redirect()->route('notes.show', $note)
            ->with('success', 'メモを作成しました。');
    }

    /**
     * 編集画面
     */
    public function edit(string $id)
    {
        $this->authorizeNote($note);
        $note->load('tags');

        // 既存タグをカンマ区切り文字列に戻す
        $tagText = $note->tags->pluck('name')->implode(', ');

        return view('notes.edit', compact('note', 'tagText'));
    }

    /**
     * 更新
     */
    public function update(Request $request, Note $note)
    {
        $this->authorizeNote($note);

        $validated = $request->validate([
            'title' => ['required', 'max:255'],
            'body'  => ['nullable'],
            'tags'  => ['nullable', 'string', 'max:255'],
        ]);

        $note->update([
            'title' => $validated['title'],
            'body'  => $validated['body'] ?? null,
        ]);

        $this->syncTags($note, $validated['tags'] ??  '');

        return redirect()->route('notes.show', $note)
            ->with('success', 'メモを更新しました。');
    }

    /**
     * 削除
     */
    public function destroy(Note $note)
    {
        $this->authorizeNote($note);
        $note->delete();

        return redirect()->route('notes.index')
            ->with('success', 'メモを削除しました。');
    }

    // 本人のメモか確認
    private function authorizeNote(Note $note): void
    {
        abort_if($note->user_id !== Auth::id(), 403);
    }

    // カンマ区切り文字列からタグを作成・紐づけ
    private function syncTags(Note $note, string $tagText):void
    {
        // カンマで分割 -> 前後空白削除 -> 空を削除 -> 重複削除
        $names = collect(explode(',', $tagText))
            ->map(fn ($name) => trim($name))
            ->filter()
            ->unique();

        $tagIds = [];

        foreach ($names as $name) {
            // 同じ名前のタグがあれば使いまわし、なければ作成
            $tag = Tag::firstOrCreate([
                'user_id' => Auth::id(),
                'name'    => $name,
            ]);
            $tagIds[] = $tag->id;
        }

        // メモに紐づくタグを一括で置き換え
        $note->tags()->sync($tagIds);
    }
}
