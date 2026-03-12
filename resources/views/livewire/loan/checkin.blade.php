
<div class="p-loan-checkin">
    @if (session('message'))
        <div class="alert-success">
        {{ session('message') }}
        </div>
      @endif

    <div class="page-container bg-page">
        <h2 class="page-title">
            返却受付
        </h2>
        <div class="page-header">
            <div class="content-area">
                
            
                <form wire:submit="update">
                    <div class="form-group">
                        <label>本の管理ID</label>
                        <div class="flex items-center gap-4">
                            <input type="text" wire:model.live="management_id" class="input-field management-id-input">
                            <div style="min-height: 24px;">
                                @if($book_title === '存在しない管理IDです')
                                    <span class="text-danger font-bold" style="color: #e74c3c;">【{{ $book_title }}】</span>
                                @elseif($book_title)
                                    <span class="text-info font-bold" style="color: #3498db;">【書名: {{ $book_title }}】</span>
                                @endif
                            </div>
                        </div>
                        @error('management_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    {{--2つのボタンを並べて配置--}}
                    <div class="action-btns">
                        <button type="button" wire:click="update" class="btn-submit">返却実行</button>
                        
                        <button type="button" 
                                wire:click="dispose" 
                                wire:confirm="本当にこの本を廃棄しますか？\n（廃棄すると元に戻せません）" 
                                class="btn-danger">廃棄実行</button>
                        
                    </div>
                </form>
            </div>
            <a href="{{ route('loan.status') }}" class="btn-simple back-link" wire:navigate>貸出状況一覧へ</a>
        </div>
    </div>
</div>

