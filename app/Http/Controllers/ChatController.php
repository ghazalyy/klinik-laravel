<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function room($bookingId)
    {
        $user    = Auth::user();
        $booking = Booking::with(['pasien', 'dokter.user'])->findOrFail($bookingId);

        // Validasi akses
        $isPasien = $booking->pasien_id === $user->id;
        $isDokter = $user->dokter && $booking->dokter_id === $user->dokter->id;
        $isAdmin  = $user->role === 'admin';

        if (!$isPasien && !$isDokter && !$isAdmin) {
            abort(403, 'Anda tidak memiliki akses ke ruang chat ini.');
        }

        $messages = Chat::where('booking_id', $bookingId)
            ->with('pengirim')
            ->orderBy('created_at')
            ->get();

        return view('chat.room', compact('booking', 'messages', 'user'));
    }

    public function getMessages($bookingId)
    {
        $messages = Chat::where('booking_id', $bookingId)
            ->with('pengirim')
            ->orderBy('created_at')
            ->get()
            ->map(fn($m) => [
                'id'          => $m->id,
                'pengirim'    => $m->pengirim->nama_lengkap,
                'pengirim_id' => $m->pengirim_id,
                'pesan'       => $m->pesan,
                'waktu'       => $m->created_at->format('H:i'),
            ]);

        return response()->json($messages);
    }

    public function sendMessage(Request $request, $bookingId)
    {
        $validated = $request->validate(['pesan' => 'required|string|max:1000']);
        $booking   = Booking::findOrFail($bookingId);
        $user      = Auth::user();

        $penerimaId = $user->id === $booking->pasien_id
            ? $booking->dokter->user_id
            : $booking->pasien_id;

        Chat::create([
            'booking_id'  => $bookingId,
            'pengirim_id' => $user->id,
            'penerima_id' => $penerimaId,
            'pesan'       => $validated['pesan'],
        ]);

        return response()->json(['status' => 'sent']);
    }

    public function endSession($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        $booking->update(['status_sesi' => 'selesai']);
        return redirect()->route('pasien.booking.riwayat')->with('success', 'Sesi chat telah diakhiri.');
    }

    public function downloadChat($bookingId)
    {
        $booking  = Booking::with(['pasien', 'dokter.user'])->findOrFail($bookingId);
        $messages = Chat::where('booking_id', $bookingId)->with('pengirim')->orderBy('created_at')->get();

        $content = "=== Riwayat Chat ===\n";
        $content .= "Pasien  : {$booking->pasien->nama_lengkap}\n";
        $content .= "Dokter  : {$booking->dokter->user->nama_lengkap}\n";
        $content .= "Tanggal : {$booking->tanggal_booking->format('d F Y')}\n";
        $content .= str_repeat('=', 40) . "\n\n";

        foreach ($messages as $msg) {
            $content .= "[{$msg->created_at->format('H:i')}] {$msg->pengirim->nama_lengkap}:\n";
            $content .= "  {$msg->pesan}\n\n";
        }

        return response($content, 200, [
            'Content-Type'        => 'text/plain',
            'Content-Disposition' => "attachment; filename=\"chat-booking-{$bookingId}.txt\"",
        ]);
    }
}
