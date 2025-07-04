<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductDiskonModel extends Model
{
    protected $table            = 'product_diskon';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['tanggal', 'nominal'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'tanggal' => 'required|valid_date',
        'nominal' => 'required|numeric|greater_than[0]'
    ];

    protected $validationMessages = [
        'tanggal' => [
            'required' => 'Tanggal harus diisi',
            'valid_date' => 'Format tanggal tidak valid'
        ],
        'nominal' => [
            'required' => 'Nominal diskon harus diisi',
            'numeric' => 'Nominal diskon harus berupa angka',
            'greater_than' => 'Nominal diskon harus lebih dari 0'
        ]
    ];

    protected $skipValidation = false;
}