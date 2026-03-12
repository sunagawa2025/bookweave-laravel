<div class="p-footer">
    
    <a href="{{ url('/') }}" class="p-image-area">
        <img src="{{ asset('images/library.jpg') }}" class="footer-logo" alt="図書館ロゴ" loading="lazy">
    </a>    
    {{-- ▲設定完了 260221 --}}

    <div class="footer-content">
        @if($config)
            <span class="company-name">{{ $config->company_name }}</span>
            <div class="company-info">
                <span>{{ $config->address }}</span>
                <span>{{ $config->phone_number }}</span>
            </div>
        @else
            <span class="company-name">図書館管理システム</span>
        @endif
    </div>
</div>