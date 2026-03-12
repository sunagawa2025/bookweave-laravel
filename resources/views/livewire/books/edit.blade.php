<div class="p-books-edit">
    
    <div class="page-container">
        <div class="page-header">
            
            <h2 class="page-title">図書編集</h2>
            
        </div>

        <form wire:submit="update" class="form-container" id="edit-form">
            <div class="form-group">
                <label class="form-label">タイトル</label>
                <input type="text" wire:model="title" class="input-field">
            </div>
            <div class="form-group">
                <label class="form-label">著者</label>
                <input type="text" wire:model="author" class="input-field">
            </div>
            <div class="form-group">
                <label class="form-label">ISBN</label>
                <input type="text" wire:model="isbn" class="input-field">
            </div>
            <div class="form-group">
                <label class="form-label">分類</label>
                <select wire:model="category_id" class="input-field">
                    <option value="">-- 未選択 --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">出版社</label>
                <input type="text" wire:model="publisher" class="input-field">
            </div>

            {{-- ▼図書画像セクション（エディット ＋ 統合画像表示） --}}
            <div class="form-group" style="margin-top: 20px;">
                <label class="form-label">図書画像</label>
                
                {{-- 画像表示エリア（1つに統合） --}}
                <div style="margin-bottom: 10px;">
                    <img src="{{ $image ? $image->temporaryUrl() : asset($book->image_path) }}" 
                         style="max-width: 120px; height: auto; border: 1px solid #ddd; padding: 3px; background: white; {{ $image ? 'border-color: #e67e22;' : '' }}">
                    @if ($image) 
                        <p style="font-size: 0.7rem; color: #e67e22; margin-top: 2px;">※保存前の新規画像プレビュー</p> 
                    @endif
                </div>

                {{-- 一体型エディットボックス --}}
                <div style="position: relative; display: flex; align-items: stretch; border: 1px solid #ccc; border-radius: 4px; overflow: hidden; height: 40px;">
                    <input type="text" wire:model="image_path" 
                           style="flex: 1; border: none; padding: 0 12px; margin: 0; outline: none; font-size: 0.9rem; pointer-events: none; cursor: default; background: #f9f9f9;" 
                           readonly
                           placeholder="example.jpg">
                    <label for="image_upload" class="btn-submit" 
                           style="width: auto; padding: 0 20px; margin: 0; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; cursor: pointer; border: none; border-radius: 0; background-color: #3498db; color: white;">
                        参照...
                    </label>
                    <input type="file" id="image_upload" wire:model.live="image" style="display: none;" accept="image/*">
                </div>
                @error('image') <span class="error-msg" style="display: block; margin-top: 5px;">{{$message}}</span>@enderror
            </div>
            
            
        </form>

        {{-- 枠の外にボタンを配置 --}}
        <div class="mt-6 flex justify-between items-center max-w-lg w-full mx-auto">
            <a href="{{ route('books.index') }}" class="btn-simple back-link" wire:navigate>一覧に戻る</a>
            
            <div class="flex gap-4">
                <button type="submit" form="edit-form" class="btn-submit px-10">更新</button>
                
            </div>
        </div>
        
        <div style="height: 200px;"></div>
    </div>
    
</div>
