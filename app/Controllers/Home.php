<?php

namespace App\Controllers;

use App\Models\ProductModel;
<<<<<<< HEAD
// Tahapan 2
use App\Models\TransactionDetailModel;
use App\Models\TransactionModel;
=======
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel; 
>>>>>>> e42709f191398b688eadf849410c56b1f5765176

class Home extends BaseController
{
    protected $product;
<<<<<<< HEAD
    // Tahapan 2
    protected $transactionModel;
    protected $transactionDetailModel;
=======
    protected $transaction;
    protected $transaction_detail;
>>>>>>> e42709f191398b688eadf849410c56b1f5765176

    function __construct()
    {
        helper('number');
        helper('form');
        $this->product = new ProductModel();
<<<<<<< HEAD
        // Tahapan 2
        $this->transactionModel = new TransactionModel();
        $this->transactionDetailModel = new TransactionDetailModel();
=======
        $this->transaction = new TransactionModel();
        $this->transaction_detail = new TransactionDetailModel();
>>>>>>> e42709f191398b688eadf849410c56b1f5765176
    }

    public function index()
    {
        $product = $this->product->findAll();
        $data['product'] = $product;

        return view('v_home', $data);
    }

    public function profile()
    {
        $username = session()->get('username');
        $data['username'] = $username;

        $buy = $this->transaction->where('username', $username)->findAll();
        $data['buy'] = $buy;

        $product = [];

        if (!empty($buy)) {
            foreach ($buy as $item) {
                $detail = $this->transaction_detail->select('transaction_detail.*, product.nama, product.harga, product.foto')->join('product', 'transaction_detail.product_id=product.id')->where('transaction_id', $item['id'])->findAll();

                if (!empty($detail)) {
                    $product[$item['id']] = $detail;
                }
            }
        }

        $data['product'] = $product;

        return view('v_profile', $data);
    }
    public function faq()
    {
        return view('v_faq');
    }

<<<<<<< HEAD
    // Tahapan 2
    public function profile()
    {
        $username = session()->get('username');
        $data['username'] = $username;

        $buy = $this->transactionModel->where('username', $username)->findAll();
        $data['buy'] = $buy;

        $product = [];

        if (!empty($buy)) {
            foreach ($buy as $item) {
                $detail = $this->transactionDetailModel->select('transaction_detail.*, product.nama, product.harga, product.foto')->join('product', 'transaction_detail.product_id=product.id')->where('transaction_id', $item['id'])->findAll();

                if (!empty($detail)) {
                    $product[$item['id']] = $detail;
                }
            }
        }

        $data['product'] = $product;

        return view('v_profile', $data);
    } // php spark make:controller ApiController --restful

=======
>>>>>>> e42709f191398b688eadf849410c56b1f5765176
    public function contact()
    {
        return view('v_contact');
    }
}
