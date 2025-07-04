<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductDiskonSeeder extends Seeder
{
    public function run()
    {
        // Set timezone Indonesia
        date_default_timezone_set('Asia/Jakarta');
        
        $data = [
            [
                'tanggal'    => '2025-07-02',
                'nominal'    => 150000,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'tanggal'    => '2025-07-03', // Hari ini (3 Juli 2025)
                'nominal'    => 250000,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'tanggal'    => '2025-07-04',
                'nominal'    => 100000,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'tanggal'    => '2025-07-05',
                'nominal'    => 300000,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'tanggal'    => '2025-07-06',
                'nominal'    => 200000,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'tanggal'    => '2025-07-07',
                'nominal'    => 350000,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'tanggal'    => '2025-07-08',
                'nominal'    => 125000,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'tanggal'    => '2025-07-09',
                'nominal'    => 400000,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'tanggal'    => '2025-07-10',
                'nominal'    => 180000,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'tanggal'    => '2025-07-11',
                'nominal'    => 275000,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Hapus data lama jika ada
        $this->db->table('product_diskon')->truncate();
        
        // Insert data ke table product_diskon
        $this->db->table('product_diskon')->insertBatch($data);
    }
}