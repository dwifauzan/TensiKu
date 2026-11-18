@props(['title', 'subtitle'])

<x-layouts.base :title="$title" class="flex flex-col items-center justify-center px-6 py-12">
    <div class="w-full max-w-sm">
        <x-brand />

        <main class="mt-10">
            <h1 class="text-2xl font-extrabold tracking-tight">{{ $title }}</h1>
            <p class="mt-1.5 text-muted">{{ $subtitle }}</p>

            <div class="mt-8">
                {{ $slot }}
            </div>

            @isset($footer)
                <p class="mt-6 text-sm text-muted">{{ $footer }}</p>
            @endisset
        </main>
    </div>
</x-layouts.base>
