@props(['user'])

<div {{ $attributes->merge(['class' => 'relative']) }} data-dropdown>
    <button
        type="button"
        class="flex items-center gap-2.5 rounded-md py-1 pr-1.5 pl-1 transition-colors hover:bg-paper focus-visible:outline-3 focus-visible:outline-cuff"
        aria-haspopup="menu"
        aria-expanded="false"
        aria-controls="profile-menu"
        data-dropdown-trigger
    >
        <span class="grid size-8 place-items-center rounded-full bg-cuff text-xs font-bold text-white">{{ $user->initials() }}</span>
        <span class="hidden max-w-36 truncate text-sm font-semibold sm:block">{{ $user->nama }}</span>
        <svg viewBox="0 0 20 20" fill="currentColor" class="size-4 text-muted" aria-hidden="true">
            <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
        </svg>
    </button>

    <div
        id="profile-menu"
        role="menu"
        class="absolute right-0 z-20 mt-2 hidden w-72 max-w-[calc(100vw-2rem)] rounded-lg border border-line bg-white shadow-[0_12px_32px_-12px_rgb(30_58_95/0.35)]"
        data-dropdown-menu
    >
        <div class="px-4 pt-4 pb-3">
            <p class="truncate font-bold">{{ $user->nama }}</p>
            <p class="truncate text-sm text-muted">{{ $user->email }}</p>
        </div>

        <dl class="mx-4 space-y-1.5 border-t border-line py-3 text-sm">
            <div class="flex justify-between gap-4">
                <dt class="text-muted">Peran</dt>
                <dd class="font-semibold">{{ str($user->role?->nama_role ?? '-')->ucfirst() }}</dd>
            </div>
            <div class="flex justify-between gap-4">
                <dt class="text-muted">Terdaftar sejak</dt>
                <dd class="font-semibold">{{ $user->created_at?->translatedFormat('j M Y') ?? '-' }}</dd>
            </div>
        </dl>

        <form method="POST" action="{{ route('logout') }}" class="border-t border-line p-1.5">
            @csrf
            <button type="submit" role="menuitem" class="w-full rounded-md px-2.5 py-2 text-left text-sm font-semibold text-ink transition-colors hover:bg-paper focus-visible:bg-paper focus-visible:outline-none">
                Keluar
            </button>
        </form>
    </div>
</div>
