<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'submiter_id' => 4, // Asumsi user ID 4 (traveler 1)
                'category_id' => 1, // Kosmetik
                'name' => 'Lipstik Matte dari Korea',
                'description' => 'Lipstik tahan lama, warna natural, dibawa dari Seoul.',
                'price' => 150000.00,
                'image' => 'images/lipstik-korea.jpg',
                'status' => 'active',
                'approval' => 'approved',
            ],
            [
                'submiter_id' => 5, // Asumsi user ID 5 (traveler 2)
                'category_id' => 1, // Kosmetik
                'name' => 'Skincare Set dari Jepang',
                'description' => 'Set essence dan moisturizer, cocok untuk kulit sensitif.',
                'price' => 500000.00,
                'image' => 'images/skincare-jepang.jpg',
                'status' => 'active',
                'approval' => 'pending',
            ],
            [
                'submiter_id' => 6, // Asumsi user ID 6 (customer 1)
                'category_id' => 2, // Makanan & Minuman
                'name' => 'Cokelat Belgia Premium',
                'description' => 'Cokelat import dari Brussels, rasa hazelnut.',
                'price' => 200000.00,
                'image' => 'images/cokelat-belgia.jpg',
                'status' => 'active',
                'approval' => 'declined',
            ],
            [
                'submiter_id' => 7, // Asumsi user ID 7 (customer 2)
                'category_id' => 2, // Makanan & Minuman
                'name' => 'Teh Hijau Matcha dari Jepang',
                'description' => 'Matcha asli Kyoto, kemasan 100g.',
                'price' => 250000.00,
                'image' => 'images/matcha-jepang.jpg',
                'status' => 'active',
                'approval' => 'pending',
            ],
            [
                'submiter_id' => 4, // Asumsi user ID 4 (traveler 1)
                'category_id' => 3, // Aksesoris Fashion
                'name' => 'Tas Sling Bag dari Paris',
                'description' => 'Tas kecil desain chic, bahan kulit sintetis.',
                'price' => 800000.00,
                'image' => 'images/tas-paris.jpg',
                'status' => 'active',
                'approval' => 'approved',
            ],
            [
                'submiter_id' => 5, // Asumsi user ID 5 (traveler 2)
                'category_id' => 3, // Aksesoris Fashion
                'name' => 'Jam Tangan Analog dari Swiss',
                'description' => 'Jam tangan waterproof, model klasik.',
                'price' => 1200000.00,
                'image' => 'images/jam-swiss.jpg',
                'status' => 'active',
                'approval' => 'declined',
            ],
            [
                'submiter_id' => 6, // Asumsi user ID 6 (customer 1)
                'category_id' => 4, // Elektronik
                'name' => 'Wireless Earbuds dari USA',
                'description' => 'Earbuds noise-cancelling, battery 20 jam.',
                'price' => 700000.00,
                'image' => 'images/earbuds-usa.jpg',
                'status' => 'active',
                'approval' => 'pending',
            ],
            [
                'submiter_id' => 7, // Asumsi user ID 7 (customer 2)
                'category_id' => 4, // Elektronik
                'name' => 'Portable Charger 10000mAh',
                'description' => 'Powerbank cepat charging, dibawa dari Singapura.',
                'price' => 300000.00,
                'image' => 'images/powerbank-singapura.jpg',
                'status' => 'active',
                'approval' => 'declined',
            ],
            [
                'submiter_id' => 4, // Asumsi user ID 4 (traveler 1)
                'category_id' => 5, // Souvenir & Hadiah
                'name' => 'Gantungan Kunci Eiffel Tower',
                'description' => 'Souvenir ikonik dari Paris, bahan metal.',
                'price' => 50000.00,
                'image' => 'images/gantungan-eiffel.jpg',
                'status' => 'active',
                'approval' => 'approved',
            ],
            [
                'submiter_id' => 5, // Asumsi user ID 5 (traveler 2)
                'category_id' => 5, // Souvenir & Hadiah
                'name' => 'Magnet Kulkas dari Bali',
                'description' => 'Magnet unik motif pantai, oleh-oleh lokal.',
                'price' => 30000.00,
                'image' => 'images/magnet-bali.jpg',
                'status' => 'active',
                'approval' => 'approved',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}