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
    public function index(Request $request)
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
        // 本人ではなく,かつ非公開なら見せない
        abort_unless($this->canView($note), 403);

        $note->load('tags', 'user', 'sharedGroupTags');
        return view('notes.show', compact('note'));
    }

    // 閲覧できるか: 本人、または共有先グループに所属している
    private function canView(Note $note): bool
    {
        $userId = Auth::id();

        // 本人は常に閲覧可
        if ($note->user_id === $userId) {
            return true;
        }

        // メモの共有先グループID
        $sharedGroupIds = $note->sharedGroupTags->pluck('id');

        // 閲覧者の所属グループID
        $myGroupIds = Auth::user()->groupTags->pluck('id');

        // 1つでも重なれば閲覧可
        return $sharedGroupIds->intersect($myGroupIds)->isNotEmpty();
    }

    /**
     * 作成画面
     */
    public function create()
    {
        $groupTags = \App\Models\GroupTag::orderBy('name')->get();
        return view('notes.create', compact('groupTags'));
    }

    /**
     * 登録
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => ['required', 'max:255'],
            'body'         => ['nullable'],
            'tags'         => ['nullable', 'string', 'max:255'],
            'group_tags'   => ['nullable', 'array'],
            'group_tags.*' => ['exists:group_tags,id'],
        ]);

        $note = Note::create([
            'user_id' => Auth::id(),
            'title'   => $validated['title'],
            'body'    => $validated['body'] ?? null,
        ]);

        $this->syncTags($note, $validated['tags'] ?? '');
        $this->syncTags($note, $validated['tags'] ?? '');
        $note->sharedGroupTags()->sync($request->input('group_tags', []));

        return redirect()->route('notes.show', $note)
            ->with('success', 'メモを作成しました。');
    }

    /**
     * 編集画面
     */
    public function edit(Note $note)
    {
        $this->authorizeNote($note);
        $note->load('tags', 'sharedGroupTags');

        // 既存タグをカンマ区切り文字列に戻す
        $tagText   = $note->tags->pluck('name')->implode(', ');
        $groupTags = \App\Models\GroupTag::orderBy('name')->get();
        $sharedIds = $note->sharedGroupTags->pluck('id')->toArray();

        return view('notes.edit', compact('note', 'tagText', 'groupTags', 'sharedIds'));
    }

    /**
     * 更新
     */
    public function update(Request $request, Note $note)
    {
        $this->authorizeNote($note);

        $validated = $request->validate([
            'title'        => ['required', 'max:255'],
            'body'         => ['nullable'],
            'tags'         => ['nullable', 'string', 'max:255'],
            'group_tags'   => ['nullable', 'array'],
            'group_tags.*' => ['exists:group_tags,id'],
        ]);

        $note->update([
            'title' => $validated['title'],
            'body'  => $validated['body'] ?? null,
        ]);

        $this->syncTags($note, $validated['tags'] ??  '');
        $this->syncTags($note, $validated['tags'] ?? '');
        $note->sharedGroupTags()->sync($request->input('group_tags', []));

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

    // 公開/非公開の切り替え(本人のみ)
    public function togglePublic(Note $note)
    {
        $this->authorizeNote($note);

        $note->update(['is_public' => !$note->is_public]);

        $message = $note->is_public ? 'メモを公開しました。' : '公開を停止しました。';

        return redirect()->route('notes.show', $note)->with('success', $message);
    }

    // 公開メモ一覧(全員が閲覧可能)
    public function publicIndex()
    {
        $notes = Note::where('is_public', true)
            ->with(['tags', 'user'])
            ->latest()
            ->get();

        return view('notes.public', compact('notes'));
    }

    // 自分に共有されているメモ一覧
    public function sharedWithMe()
    {
        $myGroupIds = Auth::user()->groupTags->pluck('id');

        $notes = Note::where('user_id', '!=', Auth::id())
            ->whereHas('sharedGroupTags', function ($query) use ($myGroupIds) {
                $query->whereIn('group_tags.id', $myGroupIds);
            })
            ->with(['tags', 'user'])
            ->latest()
            ->get();
        
        return view('notes.shared', compact('notes'));
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
