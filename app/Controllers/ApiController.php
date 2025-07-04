<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

// Tahapan 2
use App\Models\UserModel;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;
use App\Models\ProductModel;

class ApiController extends ResourceController
{
    // Tahapan 2
    protected $apiKey;
    protected $user;
    protected $transaction;
    protected $transaction_detail;
    protected $product;

    function __construct()
    {
        // Tahapan 2
        $this->apiKey = env('API_KEY');
        $this->user = new UserModel();
        $this->transaction = new TransactionModel();
        $this->transaction_detail = new TransactionDetailModel();
        $this->product = new ProductModel();
    }

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $data = [
            'results' => [],
            'status' => ["code" => 401, "description" => "Unauthorized"]
        ];

        $headers = $this->request->headers();

        array_walk($headers, function (&$value, $key) {
            $value = $value->getValue();
        });

        if (array_key_exists("Key", $headers)) {
            if ($headers["Key"] == $this->apiKey) {
                $penjualan = $this->transaction->findAll();

                foreach ($penjualan as &$pj) {
                    // Ambil detail transaksi
                    $details = $this->transaction_detail->where('transaction_id', $pj['id'])->findAll();
                    
                    // Hitung total item dan total diskon
                    $totalItem = 0;
                    $totalDiskon = 0;
                    
                    foreach ($details as &$detail) {
                        // Ambil data produk untuk setiap detail
                        $produk = $this->product->find($detail['product_id']);
                        if ($produk) {
                            $detail['nama_produk'] = $produk['nama'];
                            $detail['foto_produk'] = $produk['foto'];
                            $detail['harga_produk'] = $produk['harga'];
                        }
                        
                        $totalItem += $detail['jumlah'];
                        $totalDiskon += $detail['diskon'] * $detail['jumlah'];
                    }
                    
                    $pj['details'] = $details;
                    $pj['total_item'] = $totalItem;
                    $pj['total_diskon'] = $totalDiskon;
                }

                $data['status'] = ["code" => 200, "description" => "OK"];
                $data['results'] = $penjualan;
            }
        }

        return $this->respond($data);
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        //
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        //
    }
}

// and then make folder dashboard-toko and index.php file in it