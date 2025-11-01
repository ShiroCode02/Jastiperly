<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Kosmetik',
                'description' => 'Produk kecantikan seperti makeup, skincare dari luar negeri.',
            ],
            [
                'name' => 'Makanan & Minuman',
                'description' => 'Barang makanan import, snack, atau minuman khas luar kota/negeri.',
            ],
            [
                'name' => 'Aksesoris Fashion',
                'description' => 'Tas, sepatu, jam tangan, atau aksesoris mode dari brand internasional.',
            ],
            [
                'name' => 'Elektronik',
                'description' => 'Gadget kecil seperti charger, earphone, atau aksesoris tech yang mudah dibawa.',
            ],
            [
                'name' => 'Souvenir & Hadiah',
                'description' => 'Barang unik dari destinasi wisata, seperti gantungan kunci atau oleh-oleh.',
            ],
        ];

        foreach ($categories as $category) {
            ProductCategory::create($category);
        }
    }
}