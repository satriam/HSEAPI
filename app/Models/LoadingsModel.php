<?php

namespace App\Models;

use CodeIgniter\Model;

class LoadingsModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'loadings';
	protected $primaryKey           = 'id_loadings';
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
	protected $allowedFields        = [
		'kondisi_1','kode_bahaya_1','keterangan_1',
		'kondisi_2','kode_bahaya_2','keterangan_2',
		'kondisi_3','kode_bahaya_3','keterangan_3',
		'kondisi_4','kode_bahaya_4','keterangan_4',
		'kondisi_5','kode_bahaya_5','keterangan_5',
		'kondisi_6','kode_bahaya_6','keterangan_6',
		'kondisi_7','kode_bahaya_7','keterangan_7',
		'kondisi_8','kode_bahaya_8','keterangan_8',
		'kondisi_9','kode_bahaya_9','keterangan_9',
		'kondisi_10','kode_bahaya_10','keterangan_10',
		'kondisi_11','kode_bahaya_11','keterangan_11',
		'kondisi_12','kode_bahaya_12','keterangan_12',
		'kondisi_13','kode_bahaya_13','keterangan_13',
		'kondisi_14','kode_bahaya_14','keterangan_14',
		'kondisi_15','kode_bahaya_15','keterangan_15',
		'kondisi_16','kode_bahaya_16','keterangan_16',
		'kondisi_17','kode_bahaya_17','keterangan_17',
		'kondisi_18','kode_bahaya_18','keterangan_18',
		'kondisi_19','kode_bahaya_19','keterangan_19',
		'kondisi_20','kode_bahaya_20','keterangan_20',
		'kondisi_21','kode_bahaya_21','keterangan_21',
		'kondisi_22','kode_bahaya_22','keterangan_22',
		'kondisi_23','kode_bahaya_23','keterangan_23',
		'kondisi_24','kode_bahaya_24','keterangan_24',
		'kondisi_25','kode_bahaya_25','keterangan_25',
		'kondisi_26','kode_bahaya_26','keterangan_26',
		'created_by_id','tanggal','nama_lokasi',
		'nama_loading','shift','grup','nama_pengawas',
		'img_url_1','img_url_2','tindakan_1','tindakan_2'];

}