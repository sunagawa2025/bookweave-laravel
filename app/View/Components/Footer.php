<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
//設定情報のインポート
use App\Models\Config;


class Footer extends Component
{
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        
        $config = Config::first();
        return view('components.footer', compact('config'));
        
    }
}
