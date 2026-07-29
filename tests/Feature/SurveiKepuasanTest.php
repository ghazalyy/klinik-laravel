<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\SurveiKepuasan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SurveiKepuasanTest extends TestCase
{
    use RefreshDatabase;

    public function test_pasien_can_view_survei_page()
    {
        $pasien = User::factory()->create([
            'role' => 'pasien',
        ]);

        $response = $this->actingAs($pasien)->get(route('pasien.survei.index'));

        $response->assertStatus(200);
        $response->assertSee('Survei Kepuasan Layanan Klinik');
    }

    public function test_pasien_can_submit_survei()
    {
        $pasien = User::factory()->create([
            'role' => 'pasien',
        ]);

        $response = $this->actingAs($pasien)->post(route('pasien.survei.store'), [
            'rating_pendaftaran'    => 5,
            'rating_fasilitas'      => 4,
            'rating_pelayanan_staf' => 5,
            'rating_kebersihan'     => 5,
            'rekomendasi_nps'       => 9,
            'saran_masukan'         => 'Pelayanan klinik sangat baik dan ramah!',
        ]);

        $response->assertRedirect(route('pasien.survei.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('survei_kepuasan', [
            'pasien_id'             => $pasien->id,
            'rating_pendaftaran'    => 5,
            'rating_fasilitas'      => 4,
            'rating_pelayanan_staf' => 5,
            'rating_kebersihan'     => 5,
            'rekomendasi_nps'       => 9,
            'saran_masukan'         => 'Pelayanan klinik sangat baik dan ramah!',
        ]);
    }

    public function test_admin_can_see_survei_analytics_in_crm()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $pasien = User::factory()->create([
            'role' => 'pasien',
        ]);

        SurveiKepuasan::create([
            'pasien_id'             => $pasien->id,
            'rating_pendaftaran'    => 5,
            'rating_fasilitas'      => 5,
            'rating_pelayanan_staf' => 5,
            'rating_kebersihan'     => 5,
            'rekomendasi_nps'       => 10,
            'saran_masukan'         => 'Sangat memuaskan!',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.crm.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Analitik Kepuasan Pasien');
        $response->assertSee('Sangat memuaskan!');
    }
}
