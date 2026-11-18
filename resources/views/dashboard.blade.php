<x-layouts.app title="Dashboard">
    <h1 class="text-3xl font-extrabold tracking-tight">Halo, {{ str(auth()->user()->nama)->before(' ') }}</h1>
    <p class="mt-2 text-muted">Selamat datang di TensiKu.</p>
</x-layouts.app>
