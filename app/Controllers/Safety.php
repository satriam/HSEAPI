<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\SafetyModel;
use Firebase\JWT\JWT;

class Safety extends ResourceController
{
    protected $modelName = 'App\Models\SafetyModel';
    protected $format = 'json';
    public function index()
    {
        $data = $this->model->orderBy('id_safety', 'asc')->findAll();
        if($data == null){
            return $this->response->setJSON([
                "message" => "Tidak Ada Data"
            ]); 
        }else{
        return $this->respond($data, 200);
        }
    }



    public function create()
    {
        $db = \Config\Database::connect();

        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header)
            return $this->failUnauthorized('Token Required');
        $token = explode(' ', $header)[1];

        try {

            $decoded = JWT::decode($token, $key, ['HS256']);

            $file = $this->request->getFile('gambar1');
            $img1 = $file->getName();
            $userid = $decoded->uid;
            $keterangan = $this->request->getVar('keterangan');
            
           if ($file == Null && $keterangan == Null) {
                return $this->response->setJSON([
                    "status" => 404,
                    "message" => "Data tidak Boleh Kosong"
                ]);

            } else {
                $temp = explode(".", $img1);
                $newfilename = round(microtime(true)) . '.' . end($temp);
                $file->move("safetycampaign", $newfilename);
                $data = [
                    'created_by_id'=>$userid,
                    'img_url' => "/safetycampaign/" . $newfilename,
                    'keterangan' => $keterangan
                ];
                $builder = $db->table('safety');
                $builder->insert($data);
                return $this->response->setJSON([
                    "status" => 200,
                    "message" => "berhasil menambahkan data"
                ]);

            }



        } catch (\Throwable $th) {
          
            return $this->fail('Invalid Token');
        }

    }


    public function delete($id=NULL)
    {
        $db = \Config\Database::connect();
       $safety = $db->table("safety");
       $safety->select("*");
       $safety->where('id_safety', $id);
       $query = $safety->get();
       $abspath = $_SERVER['DOCUMENT_ROOT'];
       $gambar = $query->getRow('img_url');

       if ($safety) {
        unlink( $abspath.$gambar);
        $this->model->delete($id);

        $response = [
            'status' => 200,
            'error' => null,
            'message' => "Berhasil menghapus Data"

        ];

        return $this->respondDeleted($response);
        }
    }
}