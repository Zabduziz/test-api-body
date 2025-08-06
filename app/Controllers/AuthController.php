<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    public function login()
    {
        $userModel = new UserModel();
        $json = $this->request->getJSON();

        if (!$json || !isset($json->email) || !isset($json->password)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => false,
                'message' => 'Email dan Password wajib diisi.'
            ]);
        }

        $user = $userModel->where('email', $json->email)->first();

        if (!$user || !password_verify($json->password, $user['password'])) {
            return $this->response->setStatusCode(401)->setJSON([
                'status' => false,
                'message' => 'Login gagal. Username atau password salah.'
            ]);
        }

        return $this->response->setStatusCode(200)->setJSON([
            'status' => true,
            'message' => 'Login berhasil.',
            'data' => [
                'email' => $user['email']
            ]
        ]);
    }

    public function register()
    {
        $userModel = new UserModel();
        $json = $this->request->getJSON();

        if (!$json || !isset($json->email) || !isset($json->password)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => false,
                'message' => 'Email dan Password wajib diisi.'
            ]);
        }

        // Cek username sudah dipakai belum
        if ($userModel->where('email', $json->email)->first()) {
            return $this->response->setStatusCode(409)->setJSON([
                'status' => false,
                'message' => 'Email sudah digunakan.'
            ]);
        }

        $userModel->insert([
            'email' => $json->email,
            'password' => password_hash($json->password, PASSWORD_DEFAULT),
        ]);

        return $this->response->setStatusCode(201)->setJSON([
            'status' => true,
            'message' => 'Registrasi berhasil.'
        ]);
    }

    public function delete($id)
    {
        $userModel = new UserModel();
        $record = $userModel->find($id);

        if ($record)
        {
            return $this->response->setStatusCode(200)->setJSON([
                'status' => true,
                'message' => 'Data berhasil dihapus',
                'record' => $record
            ]);
            $userModel->delete($id);
        } else
        {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => true,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    public function getListUser()
    {
        $userModel = new UserModel();
        $data = $userModel->findAll();
        return $this->response->setStatusCode(200)->setJSON([
            'status' => true,
            'message' => 'Data berhasil diambil',
            'data' => $data
        ]);
    }
}
