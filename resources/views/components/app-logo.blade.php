@props([
    'sidebar' => false,
])

@if($sidebar)
    {{--文字が消える問題を解決するため、name属性を外し heading スロットに集約 --}}
    <flux:sidebar.brand {{ $attributes }}>
        <x-slot name="logo">
            <x-app-logo-icon class="logo-icon" />
        </x-slot>
        {{-- 文字列として渡すことで確実に表示させる --}}
        <x-slot name="name">
            図書管理システム<span class="logo-top">(Top)</span>
        </x-slot>
    </flux:sidebar.brand>
    
@else
    {{-- 文字が消える問題を解決するため、name属性を外し heading スロットに集約 --}}
    <flux:brand {{ $attributes }}>
        <x-slot name="logo">
             <img src="{{ asset('images/logo.png') }}" alt="ロゴ" class="h-8 w-auto">
        </x-slot>
        <x-slot name="name">
            図書管理システム<span class="logo-top">(Top)</span>
        </x-slot>
    </flux:brand>
    
@endif
