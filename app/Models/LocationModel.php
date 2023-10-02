<?php

namespace App\Models;

use CodeIgniter\Model;

class LocationModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'locations';
	protected $primaryKey           = 'id_locations';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['nama_lokasi','kode','gambar','path_gambar'];
}