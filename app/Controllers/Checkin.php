<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\CheckinModel;
use Firebase\JWT\JWT;

class Checkin extends ResourceController
{
 use ResponseTrait;
    protected $modelName = 'App\Models\CheckinModel';
    public function index()
    {
     $model = new CheckinModel();
        // panggil fungsi pada model
        $data = $model->tampil();
        // gunakan hasil dari fungsi model
        return $this->response->setJSON($data);
    }

    public function store()
    {
         // buat objek model
        $model = new CheckinModel();
        $kode_lokasi = $this->request->getVar('kode_lokasi');
        // panggil fungsi pada model
        $data = $model->checkinUser($kode_lokasi);
        // gunakan hasil dari fungsi model
        return $this->response->setJSON($data);
        
    }

     public function update($id = null)
{
    $data = array(
    "status" => "Checkout"
    );
   

    $check_data = $this->model->find($id);

    if (!$check_data) {
        return $this->failNotFound("Data tidak ditemukan");
    }

    $save = $this->model->update($id, $data);

    if (!$save) {
        return $this->fail($this->model->errors());
    }

    $response = [
        'status' => 200,
        'error' => null,
        'message' => "Berhasil Checkout"
    ];

    return $this->respondUpdated($response);
}
}