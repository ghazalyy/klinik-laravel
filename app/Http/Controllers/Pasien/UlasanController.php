<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\ReviewDokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    public function show($bookingId)
    {
        $booking = Booking::where('id', $bookingId)
            ->where('pasien_id', Auth::id())
            ->where('status_sesi', 'selesai')
            ->with('dokter.user')
            ->firstOrFail();

        if ($booking->reviewDokter) {
            return redirect()->route('pasien.booking.riwayat')->with('info', 'Anda sudah memberikan ulasan untuk booking ini.');
        }

        return view('pasien.ulasan.show', compact('booking'));
    }

    public function store(Request $request, $bookingId)
    {
        $booking = Booking::where('id', $bookingId)
            ->where('pasien_id', Auth::id())
            ->where('status_sesi', 'selesai')
            ->firstOrFail();

        $validated = $request->validate([
            'rating_pelayanan'  => 'required|integer|min:1|max:5',
            'rating_komunikasi' => 'required|integer|min:1|max:5',
            'ulasan'            => 'nullable|string|max:1000',
        ]);

        ReviewDokter::create([
            'booking_id'        => $booking->id,
            'pasien_id'         => Auth::id(),
            'dokter_id'         => $booking->dokter_id,
            'rating_pelayanan'  => $validated['rating_pelayanan'],
            'rating_komunikasi' => $validated['rating_komunikasi'],
            'ulasan'            => $validated['ulasan'],
        ]);

        return redirect()->route('pasien.booking.riwayat')->with('success', 'Ulasan berhasil dikirim. Terima kasih!');
    }
}
