<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use Firebase\JWT\JWT;

class Login extends ResourceController
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
		$rules = [
			'email_or_username' => 'required',
			'password' => 'required|min_length[6]'
		];
		if (!$this->validate($rules)) {
			return $this->fail($this->validator->getErrors());
		}

		$model = new UserModel();
		// $user = $model->where("email", $this->request->getVar('email_or_username'))->first();

		$user = $model->where('email', $this->request->getVar('email_or_username'))
			->orWhere('username', $this->request->getVar('email_or_username'))
			->first();
			

		if (!$user)
			return $this->response->setJSON([
				"status" => 400,
				"error" => 400,
				"message" => "Email atau Username Tidak Ditemukan",

			]);
		if ($user['status']=='proses')
		return $this->response->setJSON([
			"status" => 400,
			"error" => 400,
			"message" => "Akun Belum Aktif",

			]);

		$verify = password_verify($this->request->getVar('password'), $user['password']);
		if (!$verify)
			return $this->response->setJSON([
				"status" => 400,
				"error" => 400,
				"message" => "Password salah",

			]);

		

			$key = getenv('TOKEN_SECRET');
			$payload = array(
				'iat' => time(),
				'exp' => time() + 7200,
				// Token akan kadaluarsa dalam 1 jam
				"uid" => $user['user_id'],
				"email" => $user['email'],
				"role" => $user['role'],
				"nama" => $user['nama'],
				
			);

		$token = JWT::encode($payload, $key);
		
		return $this->response->setJSON([
			"status" => 200,
			"success" => "ok",
			"token" => $token,
			// "email" => $user['email'],
			"role" => $user['role'],
			"nama" => $user['nama'],
			"nomor_pegawai" => $user['nomor_pegawai'],
			"gambar" => $user['path_gambar'],
			"id"=>$user['user_id']
		]);
	}

// public function Logout()
// {
//     $this->session->sess_destroy();
//     redirect('login');
// }



}