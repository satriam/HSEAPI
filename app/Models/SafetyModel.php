<?php

namespace App\Models;

use CodeIgniter\Model;

class SafetyModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'safety';
	protected $primaryKey           = 'id_safety';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['img_url','keterangan','created_at','updated_at','created_by_id'];
}