<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paymentku Secure Checkout</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background: radial-gradient(circle at 10% 20%, rgb(242, 246, 253) 0%, rgb(224, 233, 248) 90.1%); }
        h1, h2, h3, h4 { font-family: 'Outfit', sans-serif; }
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.05);
        }
        .method-card {
            border: 2px solid transparent;
            transition: all 0.2s ease-in-out;
        }
        .method-card:hover {
            border-color: rgba(59, 130, 246, 0.3);
            background: rgba(59, 130, 246, 0.02);
        }
        .method-active {
            border-color: #2563eb !important;
            background: rgba(37, 99, 235, 0.04) !important;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-4xl glass-card rounded-[32px] overflow-hidden grid grid-cols-1 md:grid-cols-12">
        <!-- Sidebar Detail Transaksi -->
        <div class="md:col-span-5 bg-gradient-to-br from-blue-700 to-indigo-900 p-8 md:p-10 text-white flex flex-col justify-between relative overflow-hidden">
            <div class="absolute -right-20 -top-20 w-60 h-60 bg-white/5 rounded-full blur-3xl"></div>
            <div class="absolute -left-20 -bottom-20 w-60 h-60 bg-black/10 rounded-full blur-3xl"></div>
            
            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-8">
                    <span class="text-xl">💳</span>
                    <span class="font-extrabold text-lg tracking-wider uppercase font-mono">PAYMENTKU</span>
                </div>
                <div class="space-y-6">
                    <div>
                        <p class="text-xs text-blue-200 uppercase tracking-widest font-semibold opacity-70">Merchant</p>
                        <p class="text-lg font-bold mt-1">Klinik Pratama Orinda</p>
                    </div>
                    <div>
                        <p class="text-xs text-blue-200 uppercase tracking-widest font-semibold opacity-70">Pasien</p>
                        <p class="text-base font-medium mt-1">{{ $booking->pasien->nama_lengkap }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-blue-200 uppercase tracking-widest font-semibold opacity-70">Dokter Sesi</p>
                        <p class="text-base font-medium mt-1">dr. {{ $booking->dokter->user->nama_lengkap }}</p>
                        <p class="text-xs text-blue-300 italic">Spesialisasi: {{ $booking->dokter->spesialisasi }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-blue-200 uppercase tracking-widest font-semibold opacity-70">Order ID</p>
                        <p class="text-sm font-mono mt-1">booking-{{ $booking->id }}</p>
                    </div>
                </div>
            </div>

            <div class="relative z-10 mt-12 pt-6 border-t border-white/10">
                <p class="text-xs text-blue-200 uppercase tracking-widest font-semibold opacity-70 mb-1">Total Tagihan</p>
                <p class="text-3xl font-black italic">Rp {{ number_format($booking->pembayaran->jumlah_bayar, 0, ',', '.') }}</p>
                <p class="text-[10px] text-blue-200/50 mt-2 flex items-center gap-1">
                    <span>🔒</span> Terenkripsi 256-bit SSL
                </p>
            </div>
        </div>

        <!-- Formulir Pembayaran -->
        <div class="md:col-span-7 p-8 md:p-10 flex flex-col justify-between bg-white/70">
            <div>
                <h3 class="text-xl font-bold text-slate-800 tracking-tight mb-6">Pilih Metode Pembayaran</h3>
                
                @if(session('error'))
                    <div class="mb-4 p-4 bg-rose-50 border border-rose-100 text-rose-700 rounded-xl text-xs font-semibold">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="space-y-3" id="payment-methods">
                    <!-- QRIS -->
                    <div onclick="selectMethod('qris')" id="method-qris" class="method-card method-active rounded-2xl p-4 bg-white border border-slate-200 cursor-pointer flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center text-lg">📱</div>
                            <div>
                                <p class="font-bold text-slate-800 text-sm">QRIS / e-Wallet</p>
                                <p class="text-xs text-slate-400">Gopay, OVO, ShopeePay, LinkAja</p>
                            </div>
                        </div>
                        <input type="radio" name="payment_method" value="qris" checked class="w-4 h-4 text-blue-600">
                    </div>

                    <!-- Bank Transfer (Virtual Account) -->
                    <div onclick="selectMethod('va')" id="method-va" class="method-card rounded-2xl p-4 bg-white border border-slate-200 cursor-pointer flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-lg">🏦</div>
                            <div>
                                <p class="font-bold text-slate-800 text-sm">Virtual Account</p>
                                <p class="text-xs text-slate-400">BCA, Mandiri, BNI, BRI</p>
                            </div>
                        </div>
                        <input type="radio" name="payment_method" value="va" class="w-4 h-4 text-blue-600">
                    </div>
                </div>

                <!-- Detail QRIS Simulator -->
                <div id="details-qris" class="mt-6 p-6 bg-slate-50 border border-slate-100 rounded-2xl flex flex-col items-center">
                    <div class="bg-white p-3 rounded-2xl border border-slate-200 shadow-sm mb-3">
                        <!-- Simulated QR Code -->
                        <div class="w-40 h-40 bg-slate-100 flex flex-col items-center justify-center relative border border-slate-200">
                            <div class="w-36 h-36 border-4 border-slate-800 flex items-center justify-center bg-white font-mono text-[9px] font-bold text-center leading-tight">
                                PAYMENTKU<br>QRIS MOCKUP<br>★ ★ ★ ★ ★<br>ORDER #{{ $booking->id }}
                            </div>
                            <!-- Small Center Logo -->
                            <div class="absolute w-8 h-8 bg-blue-600 text-white font-bold rounded-lg flex items-center justify-center text-xs shadow-md border border-white">K</div>
                        </div>
                    </div>
                    <p class="text-xs text-slate-500 font-semibold">Scan QR code di atas menggunakan aplikasi mobile banking Anda.</p>
                </div>

                <!-- Detail VA Simulator -->
                <div id="details-va" class="mt-6 p-6 bg-slate-50 border border-slate-100 rounded-2xl hidden">
                    <p class="text-xs text-slate-400 uppercase tracking-wider font-bold mb-2">Nomor Virtual Account</p>
                    <div class="flex items-center justify-between bg-white px-4 py-3 border border-slate-200 rounded-xl">
                        <span class="font-mono font-bold text-slate-800 text-lg tracking-wider">88029000{{ $booking->id }}</span>
                        <span class="text-xs text-blue-600 font-bold uppercase cursor-pointer hover:underline" onclick="alert('Salin VA berhasil!')">Salin</span>
                    </div>
                    <p class="text-xs text-slate-500 mt-3 font-medium leading-relaxed">Transfer dapat dilakukan melalui ATM, Mobile Banking, maupun Internet Banking.</p>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-slate-100">
                <form method="POST" action="{{ route('paymentku.pay', $token) }}">
                    @csrf
                    <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-extrabold rounded-2xl text-base shadow-lg shadow-blue-200 transition-all transform hover:-translate-y-0.5 active:scale-95 flex items-center justify-center gap-2">
                        <span>🚀</span> BAYAR SEKARANG
                    </button>
                </form>
                <div class="mt-4 flex justify-between text-[10px] text-slate-400 font-medium">
                    <span>Kembali ke Klinik Orinda</span>
                    <a href="{{ route('pasien.booking.riwayat') }}" class="text-blue-600 hover:underline">Batalkan Transaksi</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function selectMethod(method) {
            // Reset active classes
            document.querySelectorAll('.method-card').forEach(el => el.classList.remove('method-active'));
            // Set active class
            document.getElementById('method-' + method).classList.add('method-active');
            
            // Check radio button
            document.querySelector(`input[value="${method}"]`).checked = true;

            // Toggle details panel
            if (method === 'qris') {
                document.getElementById('details-qris').classList.remove('hidden');
                document.getElementById('details-va').classList.add('hidden');
            } else {
                document.getElementById('details-qris').classList.add('hidden');
                document.getElementById('details-va').classList.remove('hidden');
            }
        }
    </script>
</body>
</html>
