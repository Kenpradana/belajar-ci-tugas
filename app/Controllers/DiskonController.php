<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProductDiskonModel;

class DiskonController extends BaseController
{
    protected $productDiskonModel;

    public function __construct()
    {
        $this->productDiskonModel = new ProductDiskonModel();
        helper('form');
    }

    public function index()
    {
        $data = [
            'diskon' => $this->productDiskonModel->orderBy('tanggal', 'DESC')->findAll()
        ];
        

        return view('v_diskon', $data);
    }

    public function add()
    {
        if ($this->request->getPost()) {
            $rules = [
                'tanggal' => 'required|valid_date',
                'nominal' => 'required|numeric|greater_than[0]'
            ];

            if ($this->validate($rules)) {
                $tanggal = $this->request->getVar('tanggal');
                $nominal = $this->request->getVar('nominal');

                // Validasi tanggal tidak boleh sama
                $existingDiskon = $this->productDiskonModel->where('tanggal', $tanggal)->first();
                if ($existingDiskon) {
                    session()->setFlashdata('failed', 'Diskon untuk tanggal ' . $tanggal . ' sudah ada!');
                    return redirect()->back();
                }

                $data = [
                    'tanggal' => $tanggal,
                    'nominal' => $nominal,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if ($this->productDiskonModel->insert($data)) {
                    session()->setFlashdata('success', 'Data diskon berhasil ditambahkan!');
                } else {
                    session()->setFlashdata('failed', 'Gagal menambahkan data diskon!');
                }
            } else {
                session()->setFlashdata('failed', $this->validator->listErrors());
            }
        }

        return redirect()->to('/diskon');
    }

    public function edit($id)
    {
        if ($this->request->getPost()) {
            $rules = [
                'nominal' => 'required|numeric|greater_than[0]'
            ];

            if ($this->validate($rules)) {
                $nominal = $this->request->getVar('nominal');

                $data = [
                    'nominal' => $nominal,
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if ($this->productDiskonModel->update($id, $data)) {
                    session()->setFlashdata('success', 'Data diskon berhasil diubah!');
                } else {
                    session()->setFlashdata('failed', 'Gagal mengubah data diskon!');
                }
            } else {
                session()->setFlashdata('failed', $this->validator->listErrors());
            }
        }

        return redirect()->to('/diskon');
    }

    public function delete($id)
    {
        if ($this->productDiskonModel->delete($id)) {
            session()->setFlashdata('success', 'Data diskon berhasil dihapus!');
        } else {
            session()->setFlashdata('failed', 'Gagal menghapus data diskon!');
        }

        return redirect()->to('/diskon');
    }


}
