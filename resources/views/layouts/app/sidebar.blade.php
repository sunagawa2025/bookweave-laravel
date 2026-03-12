<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class=" p-sidebar min-h-screen bg-white dark:bg-zinc-800">
    <flux:sidebar sticky collapsible="mobile"
        class=" w-[95%] border-e border-zinc-200 dark:border-zinc-700
        
        {{ auth()->user()->can('admin')
            ? 'bg-blue-100'
            : 'bg-emerald-300'
        }}
        
    ">
        <flux:sidebar.header>
            
            {{--サイドバーのシステム名をクリックでTopへ --}}
            <x-app-logo :sidebar="true" href="{{ route('top') }}" wire:navigate />
            
            <flux:sidebar.collapse class="lg:hidden" />
        </flux:sidebar.header>


        {{-- ▼ ここからメニュー --}}
        <flux:sidebar.nav>
    @can('admin')
    <h2 class="sidebar-group-title">管理者メニュー</h2>
            <flux:sidebar.group class="sidebar-group" heading="">
                <x-slot name="heading">
                    <span class="sidebar-heading-text-black">■　カウンター業務</span>
                </x-slot>
                <flux:sidebar.item  class="sidebar-link" href="{{route('loan.checkout')}}" wire:navigate>
                    貸出受付
                </flux:sidebar.item>
                
                <flux:sidebar.item  class="sidebar-link" href="{{route('loan.checkin')}}" wire:navigate>
                    返却受付・廃棄
                </flux:sidebar.item>
                
                <flux:sidebar.item  class="sidebar-link" href="{{route('loan.status')}}" wire:navigate>
                    貸出状況
                </flux:sidebar.item>
                <flux:sidebar.item  class="sidebar-link" href="{{route('loan.overdue')}}" wire:navigate>
                    督促管理
                </flux:sidebar.item>
            </flux:sidebar.group>

            <flux:sidebar.group class="sidebar-group" heading="">
                <x-slot name="heading">
                    <span class="sidebar-heading-text-black">■　顧客・図書管理</span>
                </x-slot>
                <flux:sidebar.item  class="sidebar-link" href="{{ route('users.index') }}" wire:navigate>
                    ユーザー管理
                </flux:sidebar.item>
                <flux:sidebar.item  class="sidebar-link" href="{{route('books.index')}}" wire:navigate>
                    図書管理
                </flux:sidebar.item>
                <flux:sidebar.item  class="sidebar-link" href="{{route('categories.index')}}" wire:navigate>
                    カテゴリー管理
                </flux:sidebar.item>
            </flux:sidebar.group>


            <flux:sidebar.group class="sidebar-group" heading="">
                <x-slot name="heading">
                    <span class="sidebar-heading-text-black">■　設定</span>
                </x-slot>
                <flux:sidebar.item  class="sidebar-link" href="{{route('configs.index')}}" wire:navigate>
                    システム共通設定
                </flux:sidebar.item>
            </flux:sidebar.group>

            @endcan
            
            @cannot('admin')
           
            <h2 class="sidebar-group-title">利用者メニュー</h2>
            <flux:sidebar.group class="sidebar-group">
                <flux:sidebar.item  class="sidebar-link" href="{{ route('books.index') }}" wire:navigate>
                    本を探す(検索)
                </flux:sidebar.item>
                <flux:sidebar.item  class="sidebar-link" href="{{ route('loan-history.index') }}" wire:navigate>
                    自分の貸出状況・履歴
                </flux:sidebar.item>
                <flux:sidebar.item  class="sidebar-link" href="{{ route('evaluations.index') }}" wire:navigate>
                    みんなのレビュー（評価一覧）
                </flux:sidebar.item>
                <flux:sidebar.item  class="sidebar-link" href="{{ route('evaluations.ranking') }}" wire:navigate>
                    図書ランキング（評価集計）
                </flux:sidebar.item>
                </flux:sidebar.group>
           
                @endcannot  
            </flux:sidebar.nav>
                {{-- ▲ ここまでメニュー --}}



        <flux:spacer />

        
        <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
    </flux:sidebar>

    <!-- Mobile User Menu -->
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown position="top" align="end">
            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <flux:avatar :name="auth()->user()->name" :initials="auth()->user()->initials()" />

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                        class="w-full cursor-pointer" data-test="logout-button">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>
</div>
    {{ $slot }}

    @fluxScripts
</body>

</html>
