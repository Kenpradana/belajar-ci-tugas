<?php


namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class TransaksiController extends BaseController
{
    protected $cart;
    // Tahapan  1
    protected $client;
    protected $apiKey;
    protected $transactionModel;
    protected $transactionDetailModel;

    function __construct()
    {
        helper('number');
        helper('form');
        $this->cart = \Config\Services::cart();
        // Tahapan 1
        $this->client = new \GuzzleHttp\Client();
        $this->apiKey = env('COST_KEY');
        $this->transactionModel = new TransactionModel();
        $this->transactionDetailModel = new TransactionDetailModel();
    }

    public function index()
    {
        $data['items'] = $this->cart->contents();
        $data['total'] = $this->cart->total();
        return view('v_keranjang', $data);
    }

    public function cart_add()
    {
        $hargaAsli = $this->request->getPost('harga');
        $diskonNominal = session()->get('diskon_nominal') ?: 0;
        
        // Hitung harga setelah diskon
        $hargaSetelahDiskon = $hargaAsli - $diskonNominal;
        
        // Pastikan harga tidak negatif
        if ($hargaSetelahDiskon < 0) {
            $hargaSetelahDiskon = 0;
        }

        $this->cart->insert(array(
            'id'        => $this->request->getPost('id'),
            'qty'       => 1,
            'price'     => $hargaSetelahDiskon, // Gunakan harga setelah diskon
            'name'      => $this->request->getPost('nama'),
            'options'   => array(
                'foto' => $this->request->getPost('foto'),
                'harga_asli' => $hargaAsli, // Simpan harga asli untuk referensi
                'diskon' => $diskonNominal, // Simpan nominal diskon
                'harga_setelah_diskon' => $hargaSetelahDiskon
            )
        ));

        $pesan = 'Produk berhasil ditambahkan ke keranjang.';
        if ($diskonNominal > 0) {
            $pesan .= ' Anda mendapat diskon ' . number_to_currency($diskonNominal, 'IDR') . '!';
        }
        $pesan .= ' (<a href="' . base_url() . 'keranjang">Lihat</a>)';

        session()->setflashdata('success', $pesan);
        return redirect()->to(base_url('/'));
    }

    public function cart_clear()
    {
        $this->cart->destroy();
        session()->setflashdata('success', 'Keranjang Berhasil Dikosongkan');
        return redirect()->to(base_url('keranjang'));
    }

    public function cart_edit()
    {
        $i = 1;
        foreach ($this->cart->contents() as $value) {
            $this->cart->update(array(
                'rowid' => $value['rowid'],
                'qty'   => $this->request->getPost('qty' . $i++)
            ));
        }

        session()->setflashdata('success', 'Keranjang Berhasil Diedit');
        return redirect()->to(base_url('keranjang'));
    }

    public function cart_delete($rowid)
    {
        $this->cart->remove($rowid);
        session()->setflashdata('success', 'Keranjang Berhasil Dihapus');
        return redirect()->to(base_url('keranjang'));
    }

    public function checkout() // Tambahan 1
    {
        $data['items'] = $this->cart->contents();
        $data['total'] = $this->cart->total();

        return view('v_checkout', $data);
    }

    // Tahapan 1
    public function getLocation()
    {
        //keyword pencarian yang dikirimkan dari halaman checkout
        $search = $this->request->getGet('search');

        $response = $this->client->request(
            'GET',
            'https://rajaongkir.komerce.id/api/v1/destination/domestic-destination?search=' . $search . '&limit=50',
            [
                'headers' => [
                    'accept' => 'application/json',
                    'key' => $this->apiKey,
                ],
            ]
        );

        $body = json_decode($response->getBody(), true);
        return $this->response->setJSON($body['data']);
    }

    public function getCost()
    {
        //ID lokasi yang dikirimkan dari halaman checkout
        $destination = $this->request->getGet('destination');

        //parameter daerah asal pengiriman, berat produk, dan kurir dibuat statis
        //valuenya => 64999 : PEDURUNGAN TENGAH , 1000 gram, dan JNE
        $response = $this->client->request(
            'POST',
            'https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost',
            [
                'multipart' => [
                    [
                        'name' => 'origin',
                        'contents' => '64999'
                    ],
                    [
                        'name' => 'destination',
                        'contents' => $destination
                    ],
                    [
                        'name' => 'weight',
                        'contents' => '1000'
                    ],
                    [
                        'name' => 'courier',
                        'contents' => 'jne'
                    ]
                ],
                'headers' => [
                    'accept' => 'application/json',
                    'key' => $this->apiKey,
                ],
            ]
        );

        $body = json_decode($response->getBody(), true);
        return $this->response->setJSON($body['data']);
    }

    public function buy()
    {
        if ($this->request->getPost()) {
            $dataForm = [
                'username' => $this->request->getPost('username'),
                'total_harga' => $this->request->getPost('total_harga'),
                'alamat' => $this->request->getPost('alamat'),
                'ongkir' => $this->request->getPost('ongkir'),
                'status' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ];

            $this->transactionModel->insert($dataForm);

            $last_insert_id = $this->transactionModel->getInsertID();

            // Ambil nominal diskon dari session
            $diskonNominal = session()->get('diskon_nominal') ?: 0;

            foreach ($this->cart->contents() as $value) {
                // Hitung subtotal dengan harga yang sudah didiskon
                $subtotalHarga = $value['qty'] * $value['price'];

                $dataFormDetail = [
                    'transaction_id' => $last_insert_id,
                    'product_id' => $value['id'],
                    'jumlah' => $value['qty'],
                    'diskon' => $diskonNominal, // Simpan nominal diskon per item
                    'subtotal_harga' => $subtotalHarga, // Subtotal sudah termasuk diskon
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ];

                $this->transactionDetailModel->insert($dataFormDetail);
            }

            $this->cart->destroy();

            // Set pesan sukses dengan informasi diskon
            if ($diskonNominal > 0) {
                session()->setFlashdata('success', 'Transaksi berhasil! Anda telah mendapat diskon ' . number_to_currency($diskonNominal, 'IDR') . ' per item.');
            } else {
                session()->setFlashdata('success', 'Transaksi berhasil!');
            }

            return redirect()->to(base_url());
        }
    }
}