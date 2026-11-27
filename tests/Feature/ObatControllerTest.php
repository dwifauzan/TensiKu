<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ObatControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_obat_and_see_it_in_the_list_and_dashboard(): void
    {
        $this->withoutVite();
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->get(route('obat.create'))
            ->assertOk()
            ->assertSee('Simpan Obat')
            ->assertSee('Contoh: 5 mg atau 1 tablet')
            ->assertSee('Tanggal Selesai (opsional)');

        $this->post(route('obat.store'), [
            'nama_obat' => 'Amlodipine',
            'dosis' => '5 mg',
            'aturan_pakai' => 'Sesudah makan',
            'frekuensi' => '1x sehari',
            'waktu_minum' => 'Pagi',
            'tanggal_mulai' => now()->toDateString(),
            'tanggal_selesai' => '',
            'catatan' => '',
        ])->assertRedirect(route('obat.index'))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('obat', [
            'pengguna_id' => $user->id,
            'nama_obat' => 'Amlodipine',
            'aktif' => true,
        ]);

        $this->get(route('obat.index'))->assertOk()->assertSee('Amlodipine');
        $this->get(route('dashboard'))->assertOk()->assertSee('Amlodipine');
    }

    public function test_invalid_end_date_shows_its_error_on_the_form(): void
    {
        $this->withoutVite();
        $this->actingAs(User::factory()->create());

        $this->from(route('obat.create'))->followingRedirects()->post(route('obat.store'), [
            'nama_obat' => 'Amlodipine',
            'dosis' => '5 mg',
            'aturan_pakai' => 'Sesudah makan',
            'frekuensi' => '1 kali sehari',
            'waktu_minum' => 'Pagi',
            'tanggal_mulai' => '2026-11-27',
            'tanggal_selesai' => '2026-11-26',
        ])->assertOk()
            ->assertSee('tanggal_selesai-error', false);

        $this->assertDatabaseCount('obat', 0);
    }
}
