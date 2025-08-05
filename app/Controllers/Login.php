<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Login extends BaseController
{
    public function index()
    {
        //
    }

    public function login()
    {
        $json = $this->request->getJSON();
        if (!$json)
        {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'invalid JSON'
            ])->setStatusCode(400);
        }
        $username = $json->username ?? null;
        $password = $json->password ?? null;
        return $this->response->setJSON([
            'status' => 'Success',
            'username' => $username
        ]);
    }
}
