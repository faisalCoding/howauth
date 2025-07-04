<x-layouts.app.admin_sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar>
