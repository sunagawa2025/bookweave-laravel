<div class="p-categories-index">
    

    <div class="page-container bg-page">
        <div class="page-header">
            <div class="left"></div>
            <h2 class="page-title">カテゴリー管理</h2>
            <div class="header-btn-area">
                <a href="{{ route('categories.create') }}" class="btn-simple" wire:navigate>新規登録</a>
            </div>
        </div>

        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>カテゴリー名</th>
                        <th class="center">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr wire:key="category-{{ $category->id }}">
                            <td class="col-category">{{$category->category_name}}</td>
                            <td class="center">
                                <a href="{{ route('categories.edit',$category->id) }}" class="admin-link" wire:navigate>編集</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{--ページネーション追加 --}}
        <div class="pagination-wrapper mt-4">
            @if(is_object($categories) && method_exists($categories, 'links'))
                {{ $categories->links() }}
            @endif
        </div>
       
    </div>
    
</div>
