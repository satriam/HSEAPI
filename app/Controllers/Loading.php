<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;

class Loading extends ResourceController
{
    protected $modelName = 'App\Models\LoadingsModel';
    protected $format = 'json';

    public function index()
    {
        $data = $this->model->orderBy('id_loadings', 'asc')->findAll();
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

        helper('text');

        $db = \Config\Database::connect();

        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header)
            return $this->failUnauthorized('Token Required');
        $token = explode(' ', $header)[1];
    
        try {
            $validate = $this->validate([
                'gambar1' => [
                    'uploaded[gambar1]',
                    'mime_in[gambar1,image/jpg,image/jpeg,image/png]',
                    'max_size[gambar1,8192]'
                ],
                'gambar2' => [
                    'mime_in[gambar2,image/jpg,image/jpeg,image/png]',
                    'max_size[gambar2,8192]'
                ]
            ]);

            $decoded = JWT::decode($token, $key, ['HS256']);
           
                $file = $this->request->getFile('gambar1');
                $img1 = $file->getName();
                $file2 = $this->request->getFile('gambar2');
                $img2 =$file2->getName();
                $dataJson = $this->request->getVar('data');
                $data = json_decode($dataJson, true);
                
                $userid = $decoded->uid;
               
                    if ($validate) {
                        // Renaming file before upload
                        $temp = explode(".", $img1);
                        $newfilename = round(microtime(true)) . '.' . end($temp);
                        $file->move("loadings", $newfilename);
                    
                            $temp2 = explode(".", $img2);
                            $newfilename2 = round(microtime(true)) .'2'. '.' . end($temp2);
                            $file2->move("loadings", $newfilename2);
                       
                        $loading = [
                            "img_url_1" => "/loadings/" . $newfilename,
                            "img_url_2" => "/loadings/" . $newfilename2,
                            "kondisi_1"=>$data['kondisi1'], 
                            "kondisi_2"=>$data['kondisi2'],
                            "kondisi_3"=>$data['kondisi3'],
                            "kondisi_4"=>$data['kondisi4'],
                            "kondisi_5"=>$data['kondisi5'],
                            "kondisi_6"=>$data['kondisi6'],
                            "kondisi_7"=>$data['kondisi7'],
                            "kondisi_8"=>$data['kondisi8'],
                            "kondisi_9"=>$data['kondisi9'],
                           "kondisi_10"=>$data['kondisi10'],
                           "kondisi_11"=>$data['kondisi11'],
                           "kondisi_12"=>$data['kondisi12'],
                           "kondisi_13"=>$data['kondisi13'],
                           "kondisi_14"=>$data['kondisi14'],
                           "kondisi_15"=>$data['kondisi15'],
                           "kondisi_16"=>$data['kondisi16'],
                           "kondisi_17"=>$data['kondisi17'],
                           "kondisi_18"=>$data['kondisi18'],
                           "kondisi_19"=>$data['kondisi19'],
                           "kondisi_20"=>$data['kondisi20'],
                           "kondisi_21"=>$data['kondisi21'],
                           "kondisi_22"=>$data['kondisi22'],
                           "kondisi_23"=>$data['kondisi23'],
                           "kondisi_24"=>$data['kondisi24'],
                           "kondisi_25"=>$data['kondisi25'],
                           "kondisi_26"=>$data['kondisi26'],
                           "kode_bahaya_1"=>$data['kode1'],
                           "kode_bahaya_2"=>$data['kode2'],
                           "kode_bahaya_3"=>$data['kode3'],
                           "kode_bahaya_4"=>$data['kode4'],
                           "kode_bahaya_5"=>$data['kode5'],
                           "kode_bahaya_6"=>$data['kode6'],
                           "kode_bahaya_7"=>$data['kode7'],
                           "kode_bahaya_8"=>$data['kode8'],
                           "kode_bahaya_9"=>$data['kode9'],
                           "kode_bahaya_10"=>$data['kode10'],
                           "kode_bahaya_11"=>$data['kode11'],
                           "kode_bahaya_12"=>$data['kode12'],
                           "kode_bahaya_13"=>$data['kode13'],
                           "kode_bahaya_14"=>$data['kode14'],
                           "kode_bahaya_15"=>$data['kode15'],
                           "kode_bahaya_16"=>$data['kode16'],
                           "kode_bahaya_17"=>$data['kode17'],
                           "kode_bahaya_18"=>$data['kode18'],
                           "kode_bahaya_19"=>$data['kode19'],
                           "kode_bahaya_20"=>$data['kode20'],
                           "kode_bahaya_21"=>$data['kode21'],
                           "kode_bahaya_22"=>$data['kode22'],
                           "kode_bahaya_23"=>$data['kode23'],
                           "kode_bahaya_24"=>$data['kode24'],
                           "kode_bahaya_25"=>$data['kode25'],
                           "kode_bahaya_26"=>$data['kode26'],
                           "keterangan_1"=>$data['keterangan1'],
                           "keterangan_2"=>$data['keterangan2'],
                           "keterangan_3"=>$data['keterangan3'],
                           "keterangan_4"=>$data['keterangan4'],
                           "keterangan_5"=>$data['keterangan5'],
                           "keterangan_6"=>$data['keterangan6'],
                           "keterangan_7"=>$data['keterangan7'],
                           "keterangan_8"=>$data['keterangan8'],
                           "keterangan_9"=>$data['keterangan9'],
                           "keterangan_10"=>$data['keterangan10'],
                           "keterangan_11"=>$data['keterangan11'],
                           "keterangan_12"=>$data['keterangan12'],
                           "keterangan_13"=>$data['keterangan13'],
                           "keterangan_14"=>$data['keterangan14'],
                           "keterangan_15"=>$data['keterangan15'],
                           "keterangan_16"=>$data['keterangan16'],
                           "keterangan_17"=>$data['keterangan17'],
                           "keterangan_18"=>$data['keterangan18'],
                           "keterangan_19"=>$data['keterangan19'],
                           "keterangan_20"=>$data['keterangan20'],
                           "keterangan_21"=>$data['keterangan21'],
                           "keterangan_22"=>$data['keterangan22'],
                           "keterangan_23"=>$data['keterangan23'],
                           "keterangan_24"=>$data['keterangan24'],
                           "keterangan_25"=>$data['keterangan25'],
                           "keterangan_26"=>$data['keterangan26'],
                           "tanggal"=>$data['tanggal'],
                            "nama_lokasi"=>$data['namalokasi'],
                            "nama_loading"=>$data['namaloading'],
                            "shift"=>$data['shift'],
                            "grup"=>$data['grup'],
                            "nama_pengawas"=>$data['pengawas'],
                            "created_by_id"=>$data['created_by_id'],
                     
                            "tindakan_1"=>$data['tindakan1'],
                            "tindakan_2"=>$data['tindakan2'],
                            
                        ];
                        // var_dump($loading);die;
                        $builder = $db->table('loadings');
                        $builder->insert($loading);
                        

                        return $this->response->setJSON([
                            "status" => 200,
                            "message" => "berhasil menambahkan data"
                        ]);

                    } else {
                        return $this->response->setJSON([
                            "status" => 403,
                            "message" => $validate
                        ]);
                    }
            } 
         catch (\Throwable $th) {
            var_dump($th);die;
            return $this->fail('Invalid Token');
        }

    }


    public function delete($id = null)
    {
        $db = \Config\Database::connect();
        //cek lokasi
        $usersTable = $db->table("loadings");
        $usersTable->select("*");
        $usersTable->where('id_loadings', $id);
        $query = $usersTable->get();
        $abspath = $_SERVER['DOCUMENT_ROOT'];
        $gambar = $query->getRow('img_url_1');
        $gambar2 = $query->getRow('img_url_2');
   

        // $check_data = $this->model->where('id', $id)->find();
        if ($usersTable) {
            unlink($abspath . $gambar);
            unlink($abspath . $gambar2);
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

    public function tampil(){
        $db = \Config\Database::connect();

    $key = getenv('TOKEN_SECRET');
    $header = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    if (!$header) {
        
        throw new \Exception('Token Required');
    }

    $token = explode(' ', $header)[1];

    $decoded = \Firebase\JWT\JWT::decode($token, $key, ['HS256']);

        $builder = $db->table('loadings');
        $builder->select('id_loadings,nama_pengawas,img_url_1,nama_lokasi,loadings.created_at');
        $builder->join('users', 'users.user_id=loadings.created_by_id');
        $builder->where('users.user_id', $decoded->uid);
        $builder->orderBy('created_at', 'DESC');
        $query = $builder->get()->getResult();
        return $this->respond($query, 200);
       
}
}