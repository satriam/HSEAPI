<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{

	protected $table = 'users';
    protected $primaryKey = 'user_id';

    protected $allowedFields = [
		'user_id',
		'email',
		'password',
		'nama',
		'role',
		'username',
		'nomor_pegawai',
		'path_gambar',
		'status',
		'perusahaan'
    ];

    protected $validationRules = [
        'email' => 'required',
        'password'=> 'required',
    ];

    protected $validationMessages = [
        'email' =>[
            'required' => 'Email tidak boleh kosong'
        ],
        'password' =>[
            'required' => 'password tidak boleh kosong'
        ],       
    ];
	protected $DBGroup              = 'default';
	

	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;


	// Dates
	protected $useTimestamps        = false;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	// Validation

	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	public function tampildata() {
		 $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->select('nama,nomor_pegawai,perusahaan,email,role,path_gambar');

        $query = $builder->get()->getResult();
		return $query;
	}

	public function tampilsemuadata(){
		$db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->select('users.id_users,email,nopeg,users.nama,roles.nama as jenis,status');
        $builder->join('roles', 'roles.id_roles=users.role_id');

        $query = $builder->get()->getResult();
        return $query;
	}

	public function tampildataa($id){
		$db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->select('users.id_users,email,nopeg,users.nama,roles.nama as jenis,status');
        $builder->join('roles', 'roles.id_roles=users.role_id');
        $builder->where('users.id_users',$id);

        $query = $builder->get()->getResult();
        return $query;
	}
}
