<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use Firebase\JWT\JWT;

class Auth extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    use ResponseTrait;
    protected $modelName = 'App\Models\UserModel';

    public function index()
    {
       
         $userModel = new UserModel();
        $data = $userModel->tampildata();
        return $this->response->setJSON($data);


    }

    public function indexall()
    {
      
        $userModel = new UserModel();
        $data = $userModel->tampilsemuadata();
         return $this->response->setJSON($data);


    }

    public function show($id=NULL)
    {
 
       $userModel = new UserModel();
        $data = $userModel->tampildataa($id);
         return $this->response->setJSON($data);


    }
    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        
        $data['id_users'] = $id;

        $check_data = $this->model->where('id_users', $id)->find();
        if (!$check_data) {
            return $this->failNotFound("Data tidak ditemukan");
        }
        $nama = $check_data[0]['nama'];

        $save = $this->model->save($data);

        if (!$save) {
            return $this->fail($this->model->errors());
        }

        $response = [
            'status' => 200,
            'error' => null,
             "message" => "Berhasil Mengubah data $nama"
        ];

        return $this->respondUpdated($response);
    }
    
    
     public function delete($id = null)
    {
        $db = \Config\Database::connect();
        //cek lokasi
        $usersTable = $db->table("users");
        $usersTable->select("*");
        $usersTable->where('id_users', $id);
        $query = $usersTable->get();
        $abspath = $_SERVER['DOCUMENT_ROOT'];
        $gambar = $query->getRow('path_gambar');

       
        if ($usersTable) {
            unlink($abspath . $gambar);

            $this->model->delete($id);

            $response = [
                'status' => 200,
                'error' => null,
                'message' => "Berhasil menghapus Data"

            ];

            return $this->respondDeleted($response);

        } else {
            return $this->failNotFound("Data tidak ditemukan");
        }
    }
    
}