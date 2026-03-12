<div class="p-categories-edit">
    

    <div class="page-container">
        <div class="page-header">
            <h2>カテゴリー編集</h2>
        </div>

        <form wire:submit="update" class="form-container">
            <div class="form-group">
                <label class="form-label">カテゴリー名</label>
                <input type="text" wire:model="category_name" class="input-field" required>
                @error('category_name') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
            
            <div class="btn-container">
                <button type="submit" class="btn-submit">更新</button>
            </div>
        </form>

        <div class="back-link-container">
            <a href="{{ route('categories.index') }}" class="btn-simple back-link" wire:navigate>一覧に戻る</a>
        </div>
    </div>
    
</div>
