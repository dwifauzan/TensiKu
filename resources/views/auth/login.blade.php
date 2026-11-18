<x-layouts.auth title="Masuk" subtitle="Masuk untuk mencatat dan memantau tekanan darahmu.">
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <x-input name="email" type="email" label="Email" autocomplete="email" required autofocus />
        <x-input name="password" type="password" label="Password" autocomplete="current-password" required />

        <label class="flex items-center gap-2 text-sm text-muted">
            <input type="checkbox" name="remember" value="1" @checked(old('remember')) class="size-4 rounded accent-cuff">
            Ingat saya
        </label>

        <x-button>Masuk</x-button>
    </form>

    <x-slot:footer>
        Belum punya akun?
        <a href="{{ route('register') }}" class="font-semibold text-cuff underline underline-offset-4 hover:text-cuff-deep">Buat akun</a>
    </x-slot:footer>
</x-layouts.auth>
