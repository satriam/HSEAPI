<?php

namespace App\Models;


use CodeIgniter\Model;
use Firebase\JWT\JWT;

class CheckinModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'checkin';
	protected $primaryKey           = 'id_checkin';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['id_checkin','lokasi_id','created_at','user_id','status','updated_at'];

    public function checkinUser($kode_lokasi)
    {
        $db = \Config\Database::connect();

        // $key = getenv('TOKEN_SECRET');
        $key ="secret";
        $header = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        if (!$header) {
            
            throw new \Exception('Token Required');
        }
        
        $token = explode(' ', $header)[1];
        
        $decoded = JWT::decode($token, $key, ['HS256']);
        // var_dump($token);die;
		// var_dump($decoded);die;

        $id_lokasi = $db->table('master_access');
        $id_lokasi->select('kode_location');
        $id_lokasi->join('locations', 'locations.id_locations=master_access.kode_location');
        $id_lokasi->where('locations.kode', $kode_lokasi);
        $id_lokasii = $id_lokasi->get()->getResult();

        if (count($id_lokasii) == 0) {
			 return [
                    "status" => 404,
                    "message" => "lokasi belum terdaftar"
                ];
        }

        $lokasi = $id_lokasii[0]->kode_location;
        $userId = $decoded->uid;
        $roleId = $decoded->role_id;

        $valid = $db->table('master_access');
        $valid->select('COUNT(*) AS count');
        $valid->where('kode_location', $lokasi);
        $valid->where('kode_role', $roleId);

        $result = $valid->get()->getRow();

        if ($result->count == 0) {
			return [
                    "status" => 404,
                    "message" => "Role Tidak Bisa Akses"
                ];
        }

        $builder = $db->table('checkin');
        $builder->select('COUNT(user_id) as total');
        $builder->where('DAY(created_at)=DAY(NOW())');
        $builder->where('HOUR(created_at)=HOUR(NOW())');
        $builder->where('user_id', $userId);
        $builder->where('lokasi_id', $lokasi);
        $hari = $builder->get()->getResult()[0]->total;

        $builder = $db->table('checkin');
        $builder->select('COUNT(user_id) as jam');
        $builder->where('HOUR(created_at)=HOUR(NOW())');
        $builder->where('user_id', $userId);
        $builder->where('lokasi_id', $lokasi);
        $jam = $builder->get()->getResult()[0]->jam;

        if ($hari < 2 && $jam == 1) {
			return [
                    "status" => 403,
                    "message" => "Sudah Melakukan Checkin"
                ];
        } elseif ($hari > 2) {
			return [
                    "status" => 402,
                    "message" => "Kuota Habis"
                ];
        }

        $builderin = $db->table('checkin');
        $data = [
            'lokasi_id' => $lokasi,
            'user_id' => $userId,
            'status'=> 'Checkin'
        ];
        $builderin->insert($data);
        return [
                    "status" => 200,
                    "message" => "Berhasil Checkin"
                ];
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

            $builder = $db->table('checkin');
            $builder->select('checkin.id_checkin,nama_lokasi,created_at,nama,locations.path_gambar,email,checkin.status,updated_at');
            $builder->join('users', 'users.id_users=checkin.user_id');
            $builder->join('locations', 'locations.id_locations=checkin.lokasi_id');
            $builder->where('users.id_users', $decoded->uid);
            $builder->orderBy('created_at', 'DESC');
            $query = $builder->get()->getResult();

            $admin = $db->table('checkin');
            $admin->select('checkin.id_checkin,nama_lokasi,created_at,nama,locations.path_gambar,email,checkin.status,updated_at');
            $admin->join('users', 'users.id_users=checkin.user_id');
            $admin->join('locations', 'locations.id_locations=checkin.lokasi_id');
            $admin->where('locations.akses', $decoded->akses);
            $adminn = $admin->get()->getResult();


            if ($decoded->akses == "user") {
				return [
                    "status" => 200,
                    "pribadi" => $query
                ];
            } else {
				return [
					"status" => 200,
					"pribadi" => $query,
					"akses" => $adminn
                ];
            }
	}


   
}
