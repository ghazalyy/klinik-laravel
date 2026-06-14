<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Dokter;
use App\Models\Pembayaran;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentkuTest extends TestCase
{
    use RefreshDatabase;

    public function test_paymentku_sandbox_payment_flow()
    {
        // 1. Setup Data
        // Pasien
        $pasien = User::create([
            'nama_lengkap' => 'Test Pasien',
            'username' => 'testpasien',
            'password' => bcrypt('password123'),
            'role' => 'pasien',
            'no_telepon' => '081234567890',
        ]);

        // Dokter User
        $dokterUser = User::create([
            'nama_lengkap' => 'Test Dokter',
            'username' => 'testdokter',
            'password' => bcrypt('password123'),
            'role' => 'dokter',
        ]);

        // Dokter
        $dokter = Dokter::create([
            'user_id' => $dokterUser->id,
            'spesialisasi' => 'Dokter Umum',
            'deskripsi' => 'Test Deskripsi',
            'harga_sesi' => 75000,
            'status_online' => 'Online',
        ]);

        // Booking
        $booking = Booking::create([
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
            'tanggal_booking' => now()->addDays(1)->format('Y-m-d'),
            'status_pembayaran' => 'pending',
            'status_sesi' => 'menunggu',
        ]);

        // Pembayaran
        $pembayaran = Pembayaran::create([
            'booking_id' => $booking->id,
            'jumlah_bayar' => 75000,
            'metode_pembayaran' => 'Transfer Bank',
        ]);

        // 2. Test Checkout Redirect (acting as Pasien)
        $response = $this->actingAs($pasien)
            ->post(route('pasien.pembayaran.checkout', ['bookingId' => $booking->id]));

        // Should redirect to simulator checkout URL
        $response->assertRedirect();
        $redirectUrl = $response->headers->get('Location');
        $this->assertStringContainsString('/paymentku/pay/', $redirectUrl);

        // Extract token
        $parts = explode('/paymentku/pay/', $redirectUrl);
        $token = end($parts);

        // 3. Test Simulator Checkout Page
        $responseCheckout = $this->get(route('paymentku.checkout', ['token' => $token]));
        $responseCheckout->assertStatus(200);
        $responseCheckout->assertViewIs('paymentku.checkout');

        // 4. Test Simulator Pay Route (triggers programmatic webhook)
        $responsePay = $this->post(route('paymentku.pay', ['token' => $token]));
        
        // Assert redirect to booking history
        $responsePay->assertRedirect(route('pasien.booking.riwayat'));
        $responsePay->assertSessionHas('success', 'Pembayaran via Paymentku berhasil diverifikasi!');

        // 5. Verify Database Changes
        $booking->refresh();
        $pembayaran->refresh();

        $this->assertEquals('lunas', $booking->status_pembayaran);
        $this->assertEquals('booking-' . $booking->id, $pembayaran->midtrans_order_id);
        $this->assertEquals('success', $pembayaran->midtrans_status);
        $this->assertEquals('Paymenku', $pembayaran->metode_pembayaran);
    }
}
