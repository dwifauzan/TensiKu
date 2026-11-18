<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DatabaseSchemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_erd_tables_have_expected_columns(): void
    {
        $this->assertTrue(Schema::hasColumns('role', ['id_role', 'nama_role']));
        $this->assertTrue(Schema::hasColumns('users', ['id', 'nama', 'email', 'password', 'is_active', 'id_role']));
        $this->assertTrue(Schema::hasColumns('pengukuran', [
            'id', 'pengguna_id', 'waktu_ukur', 'sistolik', 'diastolik', 'nadi',
            'status', 'catatan', 'created_at', 'updated_at',
        ]));
        $this->assertTrue(Schema::hasColumns('tips', [
            'id', 'dibuat_oleh', 'judul', 'isi', 'kategori', 'gambar', 'created_at', 'updated_at',
        ]));
        $this->assertTrue(Schema::hasColumns('obat', [
            'id', 'pengguna_id', 'nama_obat', 'dosis', 'aturan_pakai', 'catatan', 'created_at', 'updated_at',
        ]));
    }

    public function test_user_can_belong_to_a_role(): void
    {
        $roleId = DB::table('role')->insertGetId(['nama_role' => 'admin'], 'id_role');

        $user = User::factory()->create(['id_role' => $roleId]);

        $this->assertSame($roleId, $user->fresh()->id_role);
        $this->assertTrue($user->fresh()->is_active);
    }

    public function test_pengukuran_and_obat_are_deleted_with_their_user(): void
    {
        $user = User::factory()->create();

        DB::table('pengukuran')->insert([
            'pengguna_id' => $user->id,
            'waktu_ukur' => now(),
            'sistolik' => 118,
            'diastolik' => 76,
            'status' => 'normal',
        ]);

        DB::table('obat')->insert([
            'pengguna_id' => $user->id,
            'nama_obat' => 'Amlodipine',
            'dosis' => '5 mg',
            'aturan_pakai' => '1x sehari',
        ]);

        $user->delete();

        $this->assertDatabaseCount('pengukuran', 0);
        $this->assertDatabaseCount('obat', 0);
    }

    public function test_admin_with_tips_cannot_be_deleted(): void
    {
        $admin = User::factory()->create();

        DB::table('tips')->insert([
            'dibuat_oleh' => $admin->id,
            'judul' => 'Kurangi garam',
            'isi' => 'Batasi asupan garam harian.',
        ]);

        $this->expectException(QueryException::class);

        $admin->delete();
    }

    public function test_pengukuran_rejects_unknown_user(): void
    {
        $this->expectException(QueryException::class);

        DB::table('pengukuran')->insert([
            'pengguna_id' => 999,
            'waktu_ukur' => now(),
            'sistolik' => 118,
            'diastolik' => 76,
            'status' => 'normal',
        ]);
    }
}
