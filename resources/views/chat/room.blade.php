@extends('layouts.app')
@section('title', 'Chat — Booking #' . $booking->id)

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4">
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden flex flex-col" style="height: 80vh;">
        <!-- Header -->
        <div class="bg-blue-700 text-white p-4 flex items-center justify-between">
            <div>
                <p class="font-bold">💬 Sesi Chat Booking #{{ $booking->id }}</p>
                <p class="text-blue-200 text-sm">
                    {{ $booking->pasien->nama_lengkap }} ↔ Dr. {{ $booking->dokter->user->nama_lengkap }}
                </p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('chat.download', $booking->id) }}" class="bg-blue-600 px-3 py-1 rounded-lg text-xs hover:bg-blue-500 transition">⬇ Download</a>
                @if($user->role === 'pasien' && $booking->status_sesi === 'aktif')
                <form method="POST" action="{{ route('chat.end', $booking->id) }}">@csrf
                    <button type="submit" class="bg-red-500 px-3 py-1 rounded-lg text-xs hover:bg-red-600 transition" onclick="return confirm('Akhiri sesi?')">✖ Akhiri</button>
                </form>
                @endif
            </div>
        </div>

        <!-- Messages Area -->
        <div id="chat-messages" class="flex-1 overflow-y-auto p-4 space-y-2 bg-gray-50">
            @foreach($messages as $msg)
            <div class="flex {{ $msg->pengirim_id === $user->id ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-xs lg:max-w-md">
                    @if($msg->pengirim_id !== $user->id)
                        <p class="text-xs text-gray-500 mb-1 ml-1">{{ $msg->pengirim->nama_lengkap }}</p>
                    @endif
                    <div class="px-4 py-2 rounded-2xl text-sm
                        {{ $msg->pengirim_id === $user->id ? 'bg-blue-600 text-white rounded-tr-sm' : 'bg-white text-gray-800 shadow-sm rounded-tl-sm' }}">
                        {{ $msg->pesan }}
                        <p class="text-xs mt-1 {{ $msg->pengirim_id === $user->id ? 'text-blue-200' : 'text-gray-400' }}">
                            {{ $msg->created_at->format('H:i') }}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Input Area -->
        @if($booking->status_sesi === 'aktif' && $user->role !== 'admin')
        <div class="p-4 bg-white border-t border-gray-100">
            <form id="chat-form" class="flex gap-3">
                @csrf
                <input type="text" id="chat-input" placeholder="Ketik pesan..."
                    class="flex-1 px-4 py-2 border border-gray-200 rounded-full focus:ring-2 focus:ring-blue-500 outline-none text-sm"
                    autocomplete="off">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-full hover:bg-blue-700 transition text-sm font-medium">
                    Kirim
                </button>
            </form>
        </div>
        @else
            <div class="p-4 bg-gray-100 text-center text-sm text-gray-500">
                {{ $booking->status_sesi === 'aktif' ? 'Mode tampilan saja' : 'Sesi telah berakhir.' }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
const bookingId = {{ $booking->id }};
const userId = {{ $user->id }};
let lastId = {{ $messages->last()?->id ?? 0 }};

function scrollBottom() {
    const c = document.getElementById('chat-messages');
    c.scrollTop = c.scrollHeight;
}
scrollBottom();

// Polling setiap 3 detik
async function pollMessages() {
    const res = await fetch(`/chat/${bookingId}/messages`);
    const msgs = await res.json();
    const container = document.getElementById('chat-messages');

    msgs.filter(m => m.id > lastId).forEach(m => {
        lastId = m.id;
        const isMe = m.pengirim_id === userId;
        const div = document.createElement('div');
        div.className = `flex ${isMe ? 'justify-end' : 'justify-start'}`;
        div.innerHTML = `
            <div class="max-w-xs lg:max-w-md">
                ${!isMe ? `<p class="text-xs text-gray-500 mb-1 ml-1">${m.pengirim}</p>` : ''}
                <div class="px-4 py-2 rounded-2xl text-sm ${isMe ? 'bg-blue-600 text-white rounded-tr-sm' : 'bg-white text-gray-800 shadow-sm rounded-tl-sm'}">
                    ${m.pesan}
                    <p class="text-xs mt-1 ${isMe ? 'text-blue-200' : 'text-gray-400'}">${m.waktu}</p>
                </div>
            </div>`;
        container.appendChild(div);
        scrollBottom();
    });
}
setInterval(pollMessages, 3000);

// Send message
document.getElementById('chat-form')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const input = document.getElementById('chat-input');
    const msg = input.value.trim();
    if (!msg) return;

    await fetch(`/chat/${bookingId}/send`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
        },
        body: JSON.stringify({ pesan: msg })
    });

    input.value = '';
    await pollMessages();
});
</script>
@endpush
@endsection
