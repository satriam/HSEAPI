<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;

class Pengaduan extends ResourceController
{
    protected $modelName = 'App\Models\PengaduansModel';
    protected $format = 'json';

    public function index()
    {
        $data = $this->model->orderBy('id_pengaduan', 'asc')->findAll();
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
    
        try {
            $validate = $this->validate([
                'file' => [
                    'uploaded[file]',
                    'max_size[file,200000]',
                    'ext_in[file,png,jpg,jpeg,pdf,mp4,mpeg,quicktime]',
                ],
            ]);    
                $file = $this->request->getFile('file');
                $file1 = $file->getName();
                $nama = $this->request->getVar('nama');
                $tanggal = $this->request->getVar('tanggal');
                $lokasi_kejadian = $this->request->getVar('lokasi_kejadian');
                $kronologi = $this->request->getVar('kronologi');
                $perusahaan = $this->request->getVar('perusahaan');
                $unit = $this->request->getVar('unit');
                $nama_orang = $this->request->getVar('nama_orang');
                $nomorhp = $this->request->getVar('nomorhp');
               
                $nomorTiket = "Pengaduan/SHE/".date('YmdHis') . mt_rand(1000, 9999);


                    if ($validate) {
                        // Renaming file before upload
                        $temp = explode(".", $file1);
                        $newfilename = round(microtime(true)) . '.' . end($temp);
                        $file->move("pengaduans", $newfilename);
                        
                
                        $pengaduan = [
                            'nama' => $nama,
                            'tanggal' => $tanggal,
                            "lokasi_kejadian" => $lokasi_kejadian,
                            "file" => "/pengaduans/" . $newfilename,
                            "kronologi" => $kronologi,
                            "perusahaan" => $perusahaan,
                            "unit" => $unit,
                            "nama_orang" => $nama_orang,
                            "nomorhp" => $nomorhp,
                            "status"=> "proses",
                            "ticket"=> $nomorTiket
                        ];
                  
                        $db = \Config\Database::connect();
                        $builder = $db->table('pengaduans');
                        $builder->insert($pengaduan);
                        

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
        $usersTable = $db->table("pengaduans");
        $usersTable->select("*");
        $usersTable->where('id_pengaduan', $id);
        $query = $usersTable->get();
        $abspath = $_SERVER['DOCUMENT_ROOT'];
        $file= $query->getRow('file');
   

        // $check_data = $this->model->where('id', $id)->find();
        if ($usersTable) {
            unlink($abspath . $file);
          
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