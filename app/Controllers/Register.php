<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

use App\Models\UserModel;

class Register extends ResourceController
{
	/**
	 * Return an array of resource objects, themselves in array format
	 *
	 * @return mixed
	 */
	use ResponseTrait;
	public function index()
	{
		helper(['form']);
		$db = \Config\Database::connect();
		$rules = [
			'email' => 'required|valid_email|is_unique[users.email]',
			'password' => 'required|min_length[6]',
			'nama' => 'required',
			'gambar' => [
				'uploaded[gambar]',
				'mime_in[gambar,image/png,image/jpg,image/jpeg]',
				'max_size[gambar,2048]'
			]
		];

		//data data input
		$nama = $this->request->getVar('nama');
		$username = $this->request->getVar('username');
		$role = "user";
		$file = $this->request->getFile('gambar');
		$profile_image = $file->getName();
		$email = $this->request->getVar('email');
		$nopeg = $this->request->getVar('nomor_pegawai');
		$perusahaan = $this->request->getVar('perusahaan');
		$password = password_hash($this->request->getVar('password'), PASSWORD_BCRYPT);
		$status = "proses";
		$builder = $db->table('users');
		$builder->select('*');
            $builder->where('nomor_pegawai', $nopeg);



		//jika tervalidasi
		if (!$this->validate($rules)) {
			$errors = $this->validator->getErrors();
			// Mengembalikan pesan error validasi
			return $this->response->setJSON([
                    "status" => 400,
                    "message" => $errors
                ]);
		}else  if ($builder->countAllResults() > 0) {
		     return $this->response->setJSON([
                    "status" => 400,
                    "message" => "data sudah ada"
                ]);
		    
		}else {
			

			$temp = explode(".", $profile_image);
			$newfilename = round(microtime(true)) . '.' . end($temp);
			$file->move("user", $newfilename);
			$data = [
				'nama' => $nama,
				'role' => $role,
				"path_gambar" => "/user/" . $newfilename,
				"email" => $email,
				"password" => $password,
				"username" => $username,
				"nomor_pegawai" => $nopeg,
				"status"=>$status,
				"perusahaan"=>$perusahaan
			];
			$model = new UserModel();
			$registered = $model->save($data);

			$this->respondCreated($registered);
			return $this->response->setJSON([
				"status" => 200,
				"message" => "berhasil menambahkan data",

			]);
		}
	}
}