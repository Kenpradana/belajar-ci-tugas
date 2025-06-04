<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run()
    {
        // membuat data
        $data = [
            [
                'category_name' => 'Laptop',
                'deskripsi'  => 'Tersedia',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'category_name' => 'Monitor',
                'deskripsi'  => 'Tersedia',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'category_name' => 'CPU',
                'deskripsi'  => 'Tersedia',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'category_name' => 'RAM',
                'deskripsi'  => 'Tidak Tersedia',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'category_name' => 'Aksesoris',
                'deskripsi'  => 'Tidak Tersedia',
                'created_at' => date("Y-m-d H:i:s"),
            ]
        ];

        foreach ($data as $item) {
            // insert semua data ke tabel
            $this->db->table('product_category')->insert($item);
        }
    }
}
