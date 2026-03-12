<div class="p-users-index">
    {{-- ▼追加 260221 画像配置用プレースホルダー（コピーして使う） --}}
    {{-- <div class="p-image-area"></div> --}}
    {{-- ▲追加 260221 --}} {{-- ▼修正前 260216
    <div style="padding: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="margin: 0;">ユーザー一覧</h2>
            <a href="{{route('users.create')}}" style="padding: 10px; border: 1px solid #aaa; text-decoration: none; color: inherit;">[新規登録]</a>
        </div>
        ...
    </div>
    ▲修正前 260216 --}}

    {{-- ▼修正後 260216 --}}
    <div class="page-container bg-page">
        <div class="page-header">
            <h2 class="page-title">ユーザー 一覧</h2>
            <a href="{{ route('users.create') }}" class="btn-simple" wire:navigate>新規登録</a>
        </div>

        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>名前</th>
                        <th>メール</th>
                        <th>権限</th>
                        <th>住所</th>
                        <th>電話番号</th>
                        <th class="center">詳細</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr wire:key="user-{{ $user->id }}">
                            <td>{{ $user->id }}</td>
                            <td class="col-name">{{ $user->name }}</td>
                            <td class="col-email">{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                            <td class="col-address">{{ $user->address }}</td>
                            <td>{{ $user->phone_number }}</td>
                            <td class="center">
                                <a href="{{ route('users.show', $user->id) }}" class="btn-simple btn-small pagelink"
                                    wire:navigate>詳細</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- ▼追加 260221 ページネーション追加 --}}
        <div class="pagination-wrapper mt-4">
            @if (is_object($users) && method_exists($users, 'links'))
                {{ $users->links() }}
            @endif
        </div>
        {{-- ▲追加 260221 --}}
    </div>
    {{-- ▲修正後 260216 --}}
</div>
