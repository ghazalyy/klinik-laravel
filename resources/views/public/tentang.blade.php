@extends('layouts.app')
@section('title', 'Tentang Kami')

@section('content')
<div class="max-w-4xl mx-auto py-16 px-4">
    <div class="text-center mb-16">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Klinik Pratama Orinda</h1>
        <p class="text-xl text-gray-600">Melayani dengan Sepenuh Hati Sejak 2010</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-16">
        <div>
            <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=800&q=80" alt="Klinik" class="rounded-2xl shadow-xl">
        </div>
        <div class="space-y-6">
            <h2 class="text-2xl font-bold text-gray-800">Visi & Misi</h2>
            <p class="text-gray-600 leading-relaxed">
                Visi kami adalah menjadi pusat layanan kesehatan primer terdepan yang mengedepankan kualitas, kecepatan, dan kenyamanan pasien melalui integrasi teknologi informasi.
            </p>
            <ul class="space-y-3 text-gray-600">
                <li class="flex items-center gap-2">
                    <span class="text-blue-600">✔</span> Memberikan pelayanan medis yang profesional.
                </li>
                <li class="flex items-center gap-2">
                    <span class="text-blue-600">✔</span> Menjamin ketersediaan obat dan alat medis yang lengkap.
                </li>
                <li class="flex items-center gap-2">
                    <span class="text-blue-600">✔</span> Memudahkan akses layanan melalui sistem booking online.
                </li>
            </ul>
        </div>
    </div>

    <div class="bg-blue-600 rounded-3xl p-12 text-white text-center">
        <h2 class="text-3xl font-bold mb-6">Lokasi Kami</h2>
        <p class="mb-8 font-medium">Jam Operasional: 08:00 - 21:00 (Setiap Hari)</p>
        <div class="rounded-2xl overflow-hidden shadow-2xl mx-auto w-full">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.0492133019375!2d108.4555185!3d-7.003487799999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f15bebcf08c33%3A0xc7f590178fc12a1!2sKlinik%20Pratama%20Orinda!5e0!3m2!1sid!2sid!4v1774284104657!5m2!1sid!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</div>
@endsection
