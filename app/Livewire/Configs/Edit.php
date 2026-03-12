<?php

namespace App\Livewire\Configs;

use Livewire\Component;
use App\Models\Config;

class Edit extends Component
{
    public Config $config;

    // フォーム入力用プロパティ
    public $mail_host;
    public $mail_port;
    public $mail_username;
    public $mail_password;
    public $mail_encryption;
    public $mail_from_address;
    public $mail_from_name;
    public $loan_period_days;
    public $max_loan_count;
    public $pagination_count;
    public $app_theme;
    /*会社情報 */
    public $company_name;
    public $address;
    public $phone_number;
    

    /**
     * 初期化処理
     * ルーティングから渡されたConfigモデルを受け取り、プロパティにセットする
     */
    public function mount(Config $config)
    {
        $this->config = $config;

        $this->mail_host = $config->mail_host;
        $this->mail_port = $config->mail_port;
        $this->mail_username = $config->mail_username;
        $this->mail_password = $config->mail_password;
        $this->mail_encryption = $config->mail_encryption;
        $this->mail_from_address = $config->mail_from_address;
        $this->mail_from_name = $config->mail_from_name;
        $this->loan_period_days = $config->loan_period_days;
        $this->max_loan_count = $config->max_loan_count;
        $this->pagination_count = $config->pagination_count;
        $this->app_theme = $config->app_theme;
        /*会社情報 */
        $this->company_name = $config->company_name;
        $this->address = $config->address;
        $this->phone_number = $config->phone_number;
    }

    /**
     * バリデーションルール
     */
    protected $rules = [
        'mail_host' => 'nullable|string|max:255',
        'mail_port' => 'nullable|integer',
        'mail_username' => 'nullable|string|max:255',
        'mail_password' => 'nullable|string|max:255',
        'mail_encryption' => 'nullable|string|max:255',
        'mail_from_address' => 'nullable|email|max:255',
        'mail_from_name' => 'nullable|string|max:255',
        'loan_period_days' => 'required|integer|min:1',
        'max_loan_count' => 'required|integer|min:1',
        'pagination_count' => 'required|integer|min:1',
        'app_theme' => 'required|string|max:255',
        /* 会社情報 */
        'company_name' => 'nullable|string|max:255',
        'address' => 'nullable|string|max:255',
        'phone_number' => 'nullable|string|max:255',
    ];

    /**
     * 更新処理
     */
    public function update()
    {
        $this->validate();

        $this->config->update([
            'mail_host' => $this->mail_host,
            'mail_port' => $this->mail_port,
            'mail_username' => $this->mail_username,
            'mail_password' => $this->mail_password,
            'mail_encryption' => $this->mail_encryption,
            'mail_from_address' => $this->mail_from_address,
            'mail_from_name' => $this->mail_from_name,
            'loan_period_days' => $this->loan_period_days,
            'max_loan_count' => $this->max_loan_count,
            'pagination_count' => $this->pagination_count,
            'app_theme' => $this->app_theme,
            /* 会社情報 */
            'company_name' => $this->company_name,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
        ]);

        return redirect()->route('configs.index');
    }

    public function render()
    {
        return view('livewire.configs.edit')->layout('layouts.app');
    }
}
