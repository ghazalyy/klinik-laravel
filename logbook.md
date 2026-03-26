# Logbook Penggunaan Aplikasi Klinik

Dokumen ini berisi panduan dan pencatatan (checklist) skenario penggunaan aplikasi berdasarkan hak akses (*role*) masing-masing pengguna: Admin, Dokter, dan Pasien (User).

Gunakan tanda `[x]` pada kotak untuk menandai bahwa alur penggunaan fitur tersebut telah berhasil dites atau sedang berjalan baik.

---

## 1. Role: Administrator
Admin memiliki hak akses tertinggi untuk mengelola data utama klinik dan manajemen akun.

### Skenario Penggunaan (Fitur)
- [ ] **Login Admin**: Mampu masuk ke sistem menggunakan email/username dan password khusus admin.
- [ ] **Dashboard Utama**: Melihat ringkasan data statistik klinik (jumlah pasien, dokter aktif, rekam medis hari ini).
- [ ] **Manajemen Pengguna (CRUD)**: Menambahkan, membaca, mengubah, dan menghapus akun (Dokter, Admin lain, dan Pasien).
- [ ] **Manajemen Jadwal Praktik**: Mengatur ketersediaan dan jadwal praktik masing-masing dokter.
- [ ] **Manajemen Poli/Layanan**: Menambah atau memperbarui daftar poli dan jenis layanan kesehatan klinik.
- [ ] **Manajemen Obat/Apotek** *(opsional)*: Mengelola stok obat-obatan di klinik.

---

## 2. Role: Dokter
Akses dokter dibatasi pada penanganan pasien, jadwal personal, dan pengisian rekam medis.

### Skenario Penggunaan (Fitur)
- [ ] **Login Dokter**: Masuk ke dalam sistem menggunakan kredensial dokter.
- [ ] **Dashboard Dokter**: Melihat ringkasan pasien yang antre atau memiliki janji temu pada hari tersebut.
- [ ] **Manajemen Antrean Pasien**: Menerima dan memanggil pasien berdasarkan nomor urut/waktu booking.
- [ ] **Input Rekam Medis**: Mencatat anamnesis, diagnosa, tindakan, dan meresepkan obat untuk pasien yang sedang diperiksa.
- [ ] **Riwayat Rekam Medis**: Melihat riwayat kesehatan pasien dari kunjungan-kunjungan sebelumnya.

---

## 3. Role: Pasien (User)
Pasien menggunakan aplikasi sebagai sarana layanan untuk mempermudah pendaftaran dan melihat riwayat kesehatannya.

### Skenario Penggunaan (Fitur)
- [ ] **Registrasi Pasien Baru**: Membuat akun menggunakan NIK, nama lengkap, email, dan password.
- [ ] **Login Pasien**: Masuk ke aplikasi pasien menggunakan akun yang sudah diverifikasi.
- [ ] **Melihat Jadwal Dokter**: Melihat daftar dokter yang berpraktik beserta jam operasional mereka.
- [ ] **Pendaftaran/Booking Antrean**: Memesan jadwal konsultasi atau mengambil nomor antrean secara online.
- [ ] **Riwayat Pemeriksaan (Rekam Medis)**: Melihat hasil diagnosa dan resep dari pemeriksaan sebelumnya (read-only).
- [ ] **Profil Pengguna**: Memperbarui data diri pasien (alamat, no HP, foto profil).

---

*Catatan: Anda bisa menambahkan atau menghapus daftar fitur di atas sesuai dengan perkembangan fitur terbaru di aplikasi Anda.*
