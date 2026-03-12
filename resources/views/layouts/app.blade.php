<x-layouts::app.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}

    </flux:main>

    {{-- フッター (固定表示) --}}
    <div class="fixed bottom-0 right-0 z-50 left-0 lg:ml-80">
        <x-footer />
    </div>
</x-layouts::app.sidebar>
