# RGStore

Aplikasi Laravel untuk katalog game, pembelian top up, riwayat transaksi, dan pengelolaan pengaduan.

## Persyaratan

- PHP 8.2 atau lebih baru
- Composer
- Node.js dan npm
- Database yang didukung Laravel; konfigurasi lokal dapat menggunakan MySQL atau SQLite

## Instalasi

1. Pasang dependency PHP:

   ```sh
   composer install
   ```

2. Salin `.env.example` menjadi `.env`, lalu atur `DB_*` sesuai database lokal. Di PowerShell:

   ```powershell
   Copy-Item .env.example .env
   ```

3. Buat application key dan jalankan migration serta seeder:

   ```sh
   php artisan key:generate
   php artisan migrate --seed
   ```

4. Pasang dependency frontend dan build aset:

   ```sh
   npm install
   npm run build
   ```

5. Jalankan aplikasi:

   ```sh
   php artisan serve
   ```

Buka URL yang ditampilkan oleh Artisan. Untuk SQLite, atur `DB_CONNECTION=sqlite` dan `DB_DATABASE` ke path file database lokal sebelum menjalankan migration.

## Pengembangan dan Tes

Jalankan `npm run dev` di terminal terpisah saat mengembangkan tampilan. Tes otomatis dapat dijalankan dengan:

```sh
php artisan test
```

## Pengaduan dan Integrasi Route

User dapat membuat, melihat, mengedit, dan menghapus pengaduannya sendiri. Pengaduan dapat dikaitkan secara opsional dengan transaksi milik user tersebut. Status awal adalah `open`; admin dapat mengubahnya menjadi `in_progress`, `resolved`, atau `rejected`.

Koordinator perlu mengintegrasikan route berikut ke `routes/web.php`. Ganti route dashboard admin placeholder yang sudah ada, jangan daftarkan path dashboard dua kali:

```php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ComplaintController;

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::resource('complaints', ComplaintController::class);
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/complaints', [AdminController::class, 'complaints'])->name('complaints.index');
    Route::get('/complaints/{complaint}', [AdminController::class, 'showComplaint'])->name('complaints.show');
    Route::patch('/complaints/{complaint}/status', [AdminController::class, 'updateComplaintStatus'])->name('complaints.status');
});
```

## Penanganan Error

Halaman 404 dan 500 menampilkan pesan yang ramah pengguna tanpa stack trace atau detail teknis. Exception tetap dicatat melalui konfigurasi logging Laravel.
