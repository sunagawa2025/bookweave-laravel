<div class="p-books-create">

    <div class="page-container">
        <div class="page-header">
            <h2 class="page-title">図書登録</h2>
        </div>

        <form wire:submit.prevent="save" class="form-container">
            <div class="form-group">
                <label class="form-label">ISBN</label>
                <input type="text" wire:model="isbn" maxlength="13" required class="input-field">
                @error('isbn') <span class="error-msg">{{$message}}</span>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">タイトル</label>
                <input type="text" wire:model="title" required class="input-field">
                @error('title') <span class="error-msg">{{$message}}</span>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">著者</label>
                <input type="text" wire:model="author" required class="input-field">
                @error('author') <span class="error-msg">{{$message}}</span>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">カテゴリー</label>
                <select wire:model="category_id" class="input-field">
                    <option value="">選択してください</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                    @endforeach
                </select>
                @error('category_id') <span class="error-msg">{{$message}}</span>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">出版社</label>
                <input type="text" wire:model="publisher" class="input-field">
                @error('publisher') <span class="error-msg">{{$message}}</span>@enderror
            </div>
            {{-- ▼図書画像セクション（エディット ＋ 統合画像表示） --}}
            <div class="form-group" style="margin-top: 20px;">
                <label class="form-label">図書画像</label>
                
                {{-- 画像表示エリア（選択時のみプレビュー表示） --}}
                @if ($image || $image_path)
                    <div style="margin-bottom: 10px;">
                        <img src="{{ $image ? $image->temporaryUrl() : asset('storage/' . $image_path) }}" 
                             style="max-width: 150px; height: auto; border: 1px solid #ddd; padding: 3px; background: white; {{ $image ? 'border-color: #e67e22;' : '' }}">
                        @if ($image) 
                            <p style="font-size: 0.7rem; color: #e67e22; margin-top: 2px;">※保存前の新規画像プレビュー</p> 
                        @endif
                    </div>
                @endif

                {{-- 一体型エディットボックス --}}
                <div style="position: relative; display: flex; align-items: stretch; border: 1px solid #ccc; border-radius: 4px; overflow: hidden; height: 40px;">
                    <input type="text" wire:model="image_path" 
                           style="flex: 1; border: none; padding: 0 12px; margin: 0; outline: none; font-size: 0.9rem; pointer-events: none; cursor: default; background: #f9f9f9;" 
                           readonly
                           placeholder="example.jpg">
                    <label for="image_upload_create" class="btn-submit" 
                           style="width: auto; padding: 0 20px; margin: 0; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; cursor: pointer; border: none; border-radius: 0; background-color: #3498db; color: white;">
                        参照...
                    </label>
                    <input type="file" id="image_upload_create" wire:model.live="image" style="display: none;" accept="image/*">
                </div>
                @error('image') <span class="error-msg" style="display: block; margin-top: 5px;">{{$message}}</span>@enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">在庫数</label>
                <input type="number" wire:model="stock_count" required class="input-field">
                @error('stock_count') <span class="error-msg">{{$message}}</span>@enderror
            </div>
            
            <div class="btn-container">
                <button type="submit" class="btn-submit">登録</button>
            </div>
        </form>

        <a href="{{route('books.index')}}" class="btn-simple back-link" wire:navigate>一覧に戻る</a>
    </div>
   
</div>
