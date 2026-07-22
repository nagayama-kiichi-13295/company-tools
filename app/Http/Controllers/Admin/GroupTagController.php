<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GroupTag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupTagController extends Controller
{
    // タグ一覧+新規作成フォーム
    public function index()
    {
        $this->authorizeAdmin();

        $groupTags = GroupTag::withCount('users')->orderBy('name')->get();

        return view('admin.group_tags.index', compact('groupTags'));
    }

    // タグ作成
    public function store(Request $request)
    {
        $this->authorizeAdmin();
        $validated = $request->validate([
            'name' => ['required', 'max:50', 'unique:group_tags,name'],
        ]);

        GroupTag::create($validated);

        return redirect()->route('admin.group-tags.index')
            ->with('success', 'グループタグを作成しました。');
    }

    // タグ削除
    public function destroy(GroupTag $groupTag)
    {
        $this->authorizeAdmin();
        $groupTag->delete();

        return redirect()->route('admin.group-tags.index')
            ->with('success', 'グループタグを削除しました。');
    }

    // 社員へのタグ付与画面
    public function assign(User $user)
    {
        $this->authorizeAdmin();
        $groupTags   = GroupTag::orderBy('name')->get();
        $assignedIds = $user->groupTags->pluck('id')->toArray();

        return view('admin.group_tags.assign', compact('user', 'groupTags', 'assignedIds'));
    }

    // 付与を保存
    public function updateAssignment(Request $request, User $user)
    {
        $this->authorizeAdmin();
        $validated = $request->validate([
            'group_tags'   => ['nullable', 'array'],
            'group_tags.*' => ['exists:group_tags,id'],
        ]);
        
        // チェックされたタグに一括で置き換え
        $user->groupTags()->sync($validated['group_tags'] ?? []);

        return redirect()->route('admin.group-tags.index')
            ->with('success', $user->name .' さんのタグを更新しました。');
    }
    
    // 管理者だけ許可
    private function authorizeAdmin(): void
    {
        abort_unless(Auth::user()->is_admin, 403);
    }
}