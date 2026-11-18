<x-layouts.auth title="Buat akun" subtitle="Satu akun untuk menyimpan semua catatan tekanan darahmu.">
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <x-input name="nama" label="Nama lengkap" autocomplete="name" required autofocus />
        <x-input name="email" type="email" label="Email" autocomplete="email" required />
        <x-input name="password" type="password" label="Password" autocomplete="new-password" required />
        <x-input name="password_confirmation" type="password" label="Konfirmasi password" autocomplete="new-password" required />

        <x-button>Buat akun</x-button>
    </form>

    <x-slot:footer>
        Sudah punya akun?
        <a href="{{ route('login') }}" class="font-semibold text-cuff underline underline-offset-4 hover:text-cuff-deep">Masuk</a>
    </x-slot:footer>
</x-layouts.auth>
