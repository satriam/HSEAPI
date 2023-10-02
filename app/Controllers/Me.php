<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;
use App\Models\UserModel;




class Me extends ResourceController
{
    use ResponseTrait;

    protected $modelName = 'App\Models\UserModel';
    protected $format = 'json';

    public function index()
    {
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header)
            return $this->failUnauthorized('Token Required');
        $token = explode(' ', $header)[1];
        $decoded = JWT::decode($token, $key, ['HS256']);
        $db = \Config\Database::connect();

        try {
            $id = intval($decoded->uid);

            $builder = $db->table('users');
        $builder->select('nama,nomor_pegawai,perusahaan,email,role,path_gambar');
        $builder->where('users.user_id',$id);
            $query = $builder->get()->getResult();
	    	return $this->response->setJSON($query);
        } catch (\Throwable $th) {
            return $this->fail('Invalid Token');
        }
    }
}