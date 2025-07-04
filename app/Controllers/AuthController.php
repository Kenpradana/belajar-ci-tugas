<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\UserModel; 
use App\Models\ProductDiskonModel;

class AuthController extends BaseController
{
    function __construct()
    {
        helper('form');
        $this->user = new UserModel();
        $this->productDiskon = new ProductDiskonModel();
        
        // Set timezone Indonesia jika belum di-set di config
        date_default_timezone_set('Asia/Jakarta');
    }

    public function login()
    {
        if ($this->request->getPost()) {
            $rules = [
                'username' => 'required|min_length[6]',
                'password' => 'required|min_length[7]|numeric',
            ];

            if ($this->validate($rules)) {
                $username = $this->request->getVar('username');
                $password = $this->request->getVar('password');

                $dataUser = $this->user->where(['username' => $username])->first();

                if ($dataUser) {
                    if (password_verify($password, $dataUser['password'])) {
                        
                        // Set timezone Indonesia
                        date_default_timezone_set('Asia/Jakarta');
                        
                        // Cari data diskon berdasarkan tanggal hari ini (timezone Indonesia)
                        $today = date('Y-m-d'); // Sekarang akan menggunakan timezone Jakarta
                        $diskonHariIni = $this->productDiskon->where('tanggal', $today)->first();
                        
                        // Debug: untuk memastikan tanggal yang dicari
                        log_message('info', 'Timezone: ' . date_default_timezone_get());
                        log_message('info', 'Tanggal hari ini (WIB): ' . $today);
                        log_message('info', 'Waktu lengkap sekarang: ' . date('Y-m-d H:i:s'));
                        
                        if ($diskonHariIni) {
                            log_message('info', 'Diskon ditemukan untuk tanggal ' . $today . ': ' . json_encode($diskonHariIni));
                        } else {
                            log_message('info', 'Tidak ada diskon untuk tanggal: ' . $today);
                            // Cek semua data diskon yang ada
                            $allDiskon = $this->productDiskon->findAll();
                            log_message('info', 'Semua data diskon: ' . json_encode($allDiskon));
                        }
                        
                        // Set session data
                        $sessionData = [
                            'username' => $dataUser['username'],
                            'role' => $dataUser['role'],
                            'isLoggedIn' => TRUE
                        ];
                        
                        // Jika ada diskon hari ini, tambahkan ke session
                        if ($diskonHariIni) {
                            $sessionData['diskon_nominal'] = $diskonHariIni['nominal'];
                            $sessionData['diskon_tanggal'] = $diskonHariIni['tanggal'];
                        }
                        
                        session()->set($sessionData);

                        return redirect()->to(base_url('/'));
                    } else {
                        session()->setFlashdata('failed', 'Kombinasi Username & Password Salah');
                        return redirect()->back();
                    }
                } else {
                    session()->setFlashdata('failed', 'Username Tidak Ditemukan');
                    return redirect()->back();
                }
            } else {
                session()->setFlashdata('failed', $this->validator->listErrors());
                return redirect()->back();
            }
        }

        return view('v_login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }
}