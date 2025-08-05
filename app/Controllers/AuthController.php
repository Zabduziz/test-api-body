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

        if (!$json || !isset($json->username) || !isset($json->password)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => false,
                'message' => 'Username dan password wajib diisi.'
            ]);
        }

        $user = $userModel->where('username', $json->username)->first();

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
                'username' => $user['username']
            ]
        ]);
    }

    public function register()
    {
        $userModel = new UserModel();
        $json = $this->request->getJSON();

        if (!$json || !isset($json->username) || !isset($json->password)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => false,
                'message' => 'Username dan password wajib diisi.'
            ]);
        }

        // Cek username sudah dipakai belum
        if ($userModel->where('username', $json->username)->first()) {
            return $this->response->setStatusCode(409)->setJSON([
                'status' => false,
                'message' => 'Username sudah digunakan.'
            ]);
        }

        $userModel->insert([
            'username' => $json->username,
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
            $userModel->delete($id);
            return $this->response->setStatusCode(200)->setJSON([
                'status' => true,
                'message' => 'Data berhasil dihapus'
            ]);
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
