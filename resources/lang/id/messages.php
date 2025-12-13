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
        'approve' => 'Setujui',
        'decline' => 'Tolak',
    ],
    'statistics' => [
        'activity_duration' => 'Statistik Durasi Aktivitas',
        'login_frequency_graph' => 'Grafik ini menunjukkan frekuensi login selama seminggu terakhir.',
        'transaction_count' => 'Statistik Jumlah Transaksi',
        'transaction_frequency_graph' => 'Grafik ini menunjukkan frekuensi transaksi selama seminggu terakhir',
        '' => '',
    ],

    // Detail
    'username' => 'Nama Pengguna',
    'email' => 'Email',
    'full_name' => 'Nama Lengkap',
    'phone' => 'Telepon',
    'gender' => 'Jenis Kelamin',
    'male' => 'Laki-laki',
    'female' => 'Perempuan',
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
    'activity' => 'Aktivitas',
    'status' => 'Status',
    'ratings' => 'Peringkat',
    'last_login' => 'Masuk Terakhir',
    'login_location' => 'Lokasi Masuk',
    'total_transactions' => 'Total Transaksi',
    'transaction_completed' => 'Transaksi Selesai',
    'transaction_in_progress' => 'Transaksi Berjalan',
    'transaction_cancelled' => 'Transaksi Dibatalkan',
    '' => '',
    '' => '',
    '' => '',
    '' => '',

    // Umum
    'general_info' => 'Informasi Umum',
    'download' => 'Unduh Data',
    'save' => 'Simpan',
    'cancel' => 'Batal',
    'choose' => 'Pilih',
    'no_transactions' => 'Tidak ada transaksi',
    'no_users' => 'Tidak ada pengguna',
    'no_products' => 'Tidak ada produk',
    'no_data_changes' => 'Belum ada perubahan data',
    'previous' => 'Sebelumnya',
    'next' => 'Selanjutnya',
    'total' => 'Total',
    'not_uploaded' => 'Belum upload',
    'disable' => 'Nonaktifkan',
    'activate' => 'Aktifkan',
    'edit_user_data' => 'Edit Data Pengguna',
    'user_details' => 'Detail Pengguna',
    'example' => 'Contoh',
    '' => '',
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
    'total_users' => 'Total Pengguna',
    'user_chart' => 'Grafik Total Pengguna',
    'total_activities' => 'Total Aktivitas',
    'send_it' => 'Titip Kirim',
    'latest_transactions' => 'Transaksi Terbaru',
    '' => '',

    // Pengaturan 
    'last_updated' => 'Terakhir diperbarui',

    // Halaman profil pengguna untuk pengaturan detail pengguna
    'profile' => 'Profil',

    // Halaman preferensi pengguna untuk pengaturan bahasa
    'preference' => 'Preferensi',
    'language' => 'Bahasa',
    'indonesian' => 'Indonesia',
    'english' => 'English',

    // Halaman keamanan pengguna untuk pengaturan kata sandi
    'security' => 'Keamanan',
    'current_password' => 'Kata Sandi Lama',
    'new_password' => 'Kata Sandi Baru',
    'confirm_new_password' => 'Konfirmasi Kata Sandi Baru',
    
    // Tambah teks lain dari views super admin, misal 'dashboard' => 'Dasbor'
];