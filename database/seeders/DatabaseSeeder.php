<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Role::firstOrCreate(['nama_role' => Role::Admin]);
        $penggunaRole = Role::firstOrCreate(['nama_role' => Role::Pengguna]);

        User::factory()->create([
            'nama' => 'Test User',
            'email' => 'test@example.com',
            'id_role' => $penggunaRole->id_role,
        ]);
    }
}
