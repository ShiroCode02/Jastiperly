<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Storage;

class UserDetailSeeder extends Seeder
{
    public function run(): void
    {
        Storage::makeDirectory('public/id_cards');
        Storage::makeDirectory('public/passports');
        Storage::makeDirectory('public/accounts');

        $details = [
            // Superadmin (ID 1)
            [
                'user_id' => 1,
                'verified_type' => true,
                'name' => 'Superadmin Jastiperly',
                'phone' => '0800000000',
                'address' => 'Kantor Pusat Jastiperly',
                'date_birth' => '2000-01-01',
            ],

            // Admin (ID 2)
            [
                'user_id' => 2,
                'verified_type' => true,
                'name' => 'Admin Jastiperly',
                'phone' => '0800000001',
                'address' => 'Kantor Pusat Jastiperly',
                'date_birth' => '2000-02-02',
            ],

            // Finance (ID 3)
            [
                'user_id' => 3,
                'verified_type' => true,
                'name' => 'Finance Jastiperly',
                'phone' => '0800000002',
                'address' => 'Kantor Pusat Jastiperly',
                'date_birth' => '2000-03-03',
            ],
            // Traveler 1 (ID 4)
            [
                'user_id' => 4,
                'verified_type' => true,
                'name' => 'Ahmad Traveler1',
                'phone' => '081234567890',
                'address' => 'Jl. Sudirman No. 123, Jakarta Selatan',
                'date_birth' => '1990-05-15',
                'gender' => 'Laki-laki',
                'bank_name' => 'BCA',
                'bank_number' => '1234567890',
                'id_card_image' => $this->fakeImage('id_cards/ktp_traveler1.jpg'),
                'pasport_image' => $this->fakeImage('passports/passport_traveler1.jpg'),
                'account_image' => $this->fakeImage('accounts/rek_traveler1.jpg'),
            ],
            // Traveler 2 (ID 5)
            [
                'user_id' => 5,
                'verified_type' => true,
                'name' => 'Siti Traveler2',
                'phone' => '081298765432',
                'address' => 'Jl. Gatot Subroto No. 45, Bandung',
                'date_birth' => '1992-08-20',
                'gender' => 'Perempuan',
                'bank_name' => 'BNI',
                'bank_number' => '0987654321',
                'id_card_image' => $this->fakeImage('id_cards/ktp_traveler2.jpg'),
                'pasport_image' => $this->fakeImage('passports/passport_traveler2.jpg'),
                'account_image' => $this->fakeImage('accounts/rek_traveler2.jpg'),
            ],
            // Customer 1 (ID 6) - Pengirim
            [
                'user_id' => 6,
                'verified_type' => true,
                'name' => 'Budi Customer1',
                'phone' => '085678901234',
                'address' => 'Jl. Thamrin No. 78, Jakarta Pusat',
                'date_birth' => '1988-03-10',
                'gender' => 'Laki-laki',
                'bank_name' => 'Mandiri',
                'bank_number' => '1122334455',
                'id_card_image' => $this->fakeImage('id_cards/ktp_customer1.jpg'),
            ],
            // Customer 2 (ID 7) - Penerima
            [
                'user_id' => 7,
                'verified_type' => true,
                'name' => 'Ani Customer2',
                'phone' => '087654321098',
                'address' => 'Jl. Malioboro No. 56, Yogyakarta',
                'date_birth' => '1995-11-25',
                'gender' => 'Perempuan',
                'bank_name' => 'BRI',
                'bank_number' => '5566778899',
                'id_card_image' => $this->fakeImage('id_cards/ktp_customer2.jpg'),
            ],
        ];

        foreach ($details as $detail) {
            UserDetail::create($detail);
        }
    }

    private function fakeImage($path)
    {
        $fullPath = storage_path('app/public/' . $path);
        if (!file_exists($fullPath)) {
            $image = imagecreatetruecolor(300, 200);
            $bg = imagecolorallocate($image, 255, 255, 255);
            $text = imagecolorallocate($image, 0, 0, 0);
            imagefill($image, 0, 0, $bg);
            $filename = basename($path);
            imagestring($image, 5, 50, 80, strtoupper(str_replace('_', ' ', pathinfo($filename, PATHINFO_FILENAME))), $text);
            imagestring($image, 3, 50, 110, $filename, $text);
            imagejpeg($image, $fullPath);
            imagedestroy($image);
        }
        return $path;
    }
}