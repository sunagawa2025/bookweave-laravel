<div class="p-loan-checkout">
<div class="page-container bg-page">
        <h2 class="page-title">
            貸出受付
        </h2>
        <div class="page-header">
            <div class="content-area">
             
                <form wire:submit.prevent="save">
                    <div class="form-group">
                        <label>ユーザーID</label>
                        <div class="flex items-center gap-4">
                            <input type="text" wire:model.live="user_id" class="id-input">
                            <div style="min-height: 24px;"> {{-- 名前の有無でレイアウトが崩れないよう高さを確保 --}}
                                @if($user_name === '存在しないユーザーです')
                                    <span class="text-danger font-bold" style="color: #e74c3c;">【{{ $user_name }}】</span>
                                @elseif($user_name)
                                    <span class="text-success font-bold" style="color: #27ae60;">【氏名: {{ $user_name }} 様】</span>
                                @endif
                            </div>
                        </div>
                        @error('user_id')
                        <div class="error-message" style="margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>本の管理ID</label>
                        <div class="flex items-center gap-4">
                            <input type="text" wire:model.live="management_id" class="management-id-input">
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
                    <div class="btn-container">
                    <button type="submit" class="btn-submit">貸出実行</button></div>
                </form>
            </div>
            <a href="{{ route('loan.status') }}" class="btn-simple back-link" wire:navigate>貸出状況一覧へ</a>
        </div>
    </div>
</div>

