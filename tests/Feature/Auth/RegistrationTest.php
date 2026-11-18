<?php

namespace Tests\Feature\Auth;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_register_page_renders(): void
    {
        $this->get(route('register'))->assertOk()->assertSee('Buat akun');
    }

    public function test_new_user_can_register_as_pengguna(): void
    {
        $response = $this->post(route('register'), [
            'nama' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();

        $user = User::firstWhere('email', 'budi@example.com');

        $this->assertSame('Budi Santoso', $user->nama);
        $this->assertTrue($user->is_active);
        $this->assertSame(Role::Pengguna, $user->role->nama_role);
    }

    public function test_registration_reuses_existing_pengguna_role(): void
    {
        $role = Role::factory()->create();

        $this->post(route('register'), [
            'nama' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertDatabaseCount('role', 1);
        $this->assertSame($role->id_role, User::firstWhere('email', 'budi@example.com')->id_role);
    }

    public function test_registration_requires_unique_email_and_matching_password(): void
    {
        User::factory()->create(['email' => 'budi@example.com']);

        $this->post(route('register'), [
            'nama' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => 'password',
            'password_confirmation' => 'different',
        ])->assertSessionHasErrors(['email', 'password']);

        $this->assertGuest();
    }
}
