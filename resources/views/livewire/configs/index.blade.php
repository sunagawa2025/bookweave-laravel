<div class="p-configs-index">
   
    <div class="bg-page">
        <div class="page-container">
            <div class="page-header">
                <h2 class="page-title text-center w-full">システム共通設定一覧</h2>
            </div>

            
            <div class="config-sections pb-40">
                {{-- メール設定 --}}
                <div class="section-margin">
                    <div class="flex justify-between items-center mb-1">
                        <h3>メール送信設定</h3>
                       
                        <a href="{{ route('configs.edit', $config) }}" class="btn-simple whitespace-nowrap" wire:navigate>編集へ</a>
                       
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>設定名</th>
                                <th>現在の値</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $mailItems = [
                                    ['label' => 'SMTPサーバー', 'value' => $config->mail_host],
                                    ['label' => 'ポート番号', 'value' => $config->mail_port],
                                    ['label' => 'メールユーザー名', 'value' => $config->mail_username],
                                    ['label' => 'メールパスワード', 'value' => '********'], 
                                    ['label' => '暗号化方式', 'value' => $config->mail_encryption ?: '指定なし'],
                                    ['label' => '送信元アドレス', 'value' => $config->mail_from_address],
                                    ['label' => '送信者名', 'value' => $config->mail_from_name],
                                ];
                            @endphp
                            @foreach($mailItems as $item)
                                <tr>
                                    <th>{{ $item['label'] }}</th>
                                    <td>{{ $item['value'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- 組織・会社情報 --}}
                <div class="section-margin">
                    <h3>組織・会社情報</h3>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>設定名</th>
                                <th>現在の値</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $companyItems = [
                                    ['label' => '組織・会社名', 'value' => $config->company_name],
                                    ['label' => '住所', 'value' => $config->address],
                                    ['label' => '電話番号', 'value' => $config->phone_number],
                                ];
                            @endphp
                            @foreach($companyItems as $item)
                                <tr>
                                    <th>{{ $item['label'] }}</th>
                                    <td>{{ $item['value'] ?: '未登録' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
               

                {{-- 運用・表示設定 --}}
                <div class="section-margin">
                    <h3>運用・表示設定</h3>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>設定名</th>
                                <th>現在の値</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $appItems = [
                                    ['label' => '標準貸出期間(日)', 'value' => $config->loan_period_days],
                                    ['label' => '最大貸出冊数', 'value' => $config->max_loan_count],
                                    ['label' => '1ページ表示件数', 'value' => $config->pagination_count],
                                    ['label' => 'システムテーマ', 'value' => $config->app_theme],
                                ];
                            @endphp
                            @foreach($appItems as $item)
                                <tr>
                                    <th>{{ $item['label'] }}</th>
                                    <td>{{ $item['value'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</div>
