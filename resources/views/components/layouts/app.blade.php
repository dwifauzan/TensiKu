@props(['title' => null])

<x-layouts.base :title="$title">
    <header class="border-b border-line bg-white">
        <nav class="mx-auto flex h-16 max-w-5xl items-stretch justify-between px-4 sm:px-6">
            <div class="flex items-stretch gap-10">
                <x-brand class="self-center" />

                <a
                    href="{{ route('obat.index') }}"
                    @class([
                        'flex items-center border-b-2 pt-0.5 text-sm font-semibold transition-colors',
                        'border-cuff text-ink' => request()->routeIs('obat.*'),
                        'border-transparent text-muted hover:text-ink' => ! request()->routeIs('obat.*'),
                    ])
                >
                    Catatan Obat
                </a>

                <a
                    href="{{ route('tips.index') }}"
                    @class([
                        'flex items-center border-b-2 pt-0.5 text-sm font-semibold transition-colors',
                        'border-cuff text-ink' => request()->routeIs('tips.*') || request()->routeIs('admin.tips.*'),
                        'border-transparent text-muted hover:text-ink' => ! (request()->routeIs('tips.*') || request()->routeIs('admin.tips.*')),
                    ])
                >
                    Tips Kesehatan
                </a>
            </div>

            <x-profile-dropdown :user="auth()->user()" class="self-center" />
        </nav>
    </header>

    <main class="mx-auto max-w-5xl px-4 py-10 sm:px-6">
        {{ $slot }}
    </main>
</x-layouts.base>