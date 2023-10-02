<?php

namespace App\Models;

use CodeIgniter\Model;

class PengaduansModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'pengaduans';
	protected $primaryKey           = 'id_pengaduan';
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
	protected $allowedFields        = ['nama','tanggal','lokasi_kejadian','kronologi','perusahaan','unit',
'nama_orang','nomorhp','file'];
}