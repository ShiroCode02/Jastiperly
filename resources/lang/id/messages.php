<?php
return [

    // Nama, Peran, Status, DLL
    'names' => [
        'traveler' => 'Nama Traveler',
        'customer' => 'Nama Penitip',
    ],
    'roles' => [
        'superadmin' => 'Super Admin',
        'admin' => 'Admin',
        'finance' => 'Finance',
        'customer' => 'Penitip',
        'traveler' => 'Traveler',
    ],
    'users_status' => [
        'Online' => 'Online',
        'active' => 'Aktif',
        'Offline' => 'Offline',
        'inactive' => 'Nonaktif',
    ],
    'users_gender' => [
        'male' => 'Laki-laki',
        'female' => 'Perempuan',
    ],
    'transaction_types' => [
        'buy' => 'Titip Beli',
        'send' => 'Titip Kirim',
    ],
    'transactions_status' => [
        'pending' => 'Belum Bayar',
        'approved' => 'Selesai',
        'declined' => 'Dibatalkan',
    ],
    'refunds_status' => [
        'pending' => 'Proses',
        'approved' => 'Selesai',
        'declined' => 'Dibatalkan',
    ],
    'actions' => [
        'details' => 'Detail',
        'edit' => 'Edit',
        'delete' => 'Hapus',
        'save' => 'Simpan',
        'cancel' => 'Batal',
        'download' => 'Unduh Data',
        'disable' => 'Nonaktifkan',
        'activate' => 'Aktifkan',
        'approve' => 'Setuju',
        'decline' => 'Tolak',
        'closed' => 'Tutup',
        'validation' => 'Validasi',
    ],
    'tabs' => [
        // Pengaturan
        'profile' => 'Profil',
        'preference' => 'Preferensi',
        'security' => 'Keamanan',
    ],
    'filters' => [
        'all' => 'Semua',
        'choose' => 'Pilih',
        'validation' => 'Validasi',
        'approved' => 'Disetujui',
        'rejected' => 'Ditolak',
        '' => '',
    ],
    'statistics' => [
        'activity_duration' => 'Statistik Durasi Aktivitas',
        'login_frequency_graph' => 'Grafik ini menunjukkan frekuensi login selama seminggu terakhir.',
        'transaction_count' => 'Statistik Jumlah Transaksi',
        'transaction_frequency_graph' => 'Grafik ini menunjukkan frekuensi transaksi selama seminggu terakhir',
        '' => '',
    ],
    'confirmations' => [
        'delete_user' => 'Apakah Anda yakin ingin menghapus pengguna ini?',
        '' => '',
    ],
    'success' => [
        'user_deleted' => 'Pengguna berhasil dihapus',
        '' => '',
    ],
    'labels' => [
        'username' => 'Nama Pengguna',
        'full_name' => 'Nama Lengkap',
        'email' => 'Email',
        'phone' => 'Telepon',
        'gender' => 'Jenis Kelamin',
        'address' => 'Alamat',
        'full_address' => 'Alamat Lengkap',
        'city_country' => 'Negara/Kota Asal',
        'date_birth' => 'Tanggal Lahir',
        'gender' => 'Jenis Kelamin',
        'bank_account' => 'Rekening Bank',
        'bank_account_number' => 'No. Rekening',
        'joined_date' => 'Tanggal Bergabung',
        'account_status' => 'Status Akun',
        'password' => 'Kata Sandi',
        'activity_status' => 'Status Aktivitas',
        'photo_id_card' => 'Foto KTP',
        'photo_bank_account' => 'Foto Rekening',
        'photo_passport' => 'Foto Paspor',
        'status' => 'Status',
        'ratings' => 'Peringkat',
        'last_login' => 'Masuk Terakhir',
        'login_location' => 'Lokasi Masuk',
        'total_users' => 'Total Pengguna',
        'total_transactions' => 'Total Transaksi',
        'transaction_completed' => 'Transaksi Selesai',
        'transaction_in_progress' => 'Transaksi Berjalan',
        'transaction_cancelled' => 'Transaksi Dibatalkan',

        // Produk
        'name_of_goods' => 'Nama Barang',
        'item_description' => 'Deskripsi Barang',
        'price_of_goods' => 'Harga Barang',
        'reasons' => 'Alasan Penolakan',
    ],

    // Umum
    'general_info' => 'Informasi Umum',
    'activity' => 'Aktivitas',
    'no_transactions' => 'Tidak ada transaksi',
    'no_users' => 'Tidak ada pengguna',
    'no_products' => 'Tidak ada produk',
    'no_data_changes' => 'Belum ada perubahan data',
    'previous' => 'Sebelumnya',
    'next' => 'Selanjutnya',
    'total' => 'Total',
    'not_uploaded' => 'Belum upload',
    'edit_user_data' => 'Edit Data Pengguna',
    'user_details' => 'Detail Pengguna',
    'example' => 'Contoh',
    '' => '',
    '' => '',
    '' => '',
    '' => '',
    '' => '',


    // Judul halaman utama dan menu
    'dashboard' => 'Dashboard',
    'user_management' => 'Manajemen Pengguna',
    'product_management' => 'Manajemen Produk',
    'transactions' => 'Transaksi',
    'refunds' => 'Pengembalian Dana',
    'settings' => 'Pengaturan',

    // Dashboard
    'hi' => 'Hai',
    'welcome_back' => 'Selamat datang kembali di Dashboard SuperAdmin',
    'user_chart' => 'Grafik Total Pengguna',
    'total_activities' => 'Total Aktivitas',
    'latest_transactions' => 'Transaksi Terbaru',
    '' => '',

    // Pengaturan 
    'last_updated' => 'Terakhir diperbarui',

    // Halaman preferensi pengguna untuk pengaturan bahasa
    'language' => 'Bahasa',
    'indonesian' => 'Indonesia',
    'english' => 'English',

    // Halaman keamanan pengguna untuk pengaturan kata sandi
    'current_password' => 'Kata Sandi Lama',
    'new_password' => 'Kata Sandi Baru',
    'confirm_new_password' => 'Konfirmasi Kata Sandi Baru',
    
    // Tambah teks lain dari views super admin, misal 'dashboard' => 'Dasbor'
];