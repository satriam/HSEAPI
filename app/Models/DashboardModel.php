<?php

namespace App\Models;

use CodeIgniter\Model;

class DashboardModel extends Model
{
	 public function cc()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('checkin');
        $builder->select('COUNT(*) as totalCheckin');
        $query = $builder->get()->getResult();
        return $query;
    }
    public function ca()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('roles');
        $builder->select('COUNT(*) as totalRole');
        $query = $builder->get()->getResult();
        return $query;
    }

    public function kc()
    {
        $db = \Config\Database::connect();

        $queryString = "SELECT YEAR(created_at) AS year, MONTHNAME(created_at) AS month, COUNT(*) AS count FROM checkin
            GROUP BY year, month
            ORDER BY MONTH(created_at); ";
        $query = $db->query($queryString);
        $result = $query->getResult();
        // var_dump($result);die;
        return $result;

    }

    public function persentase()
    {
        $checkinModel = new CheckinModel();
        $builder = $checkinModel->db->table('checkin');

        // Mengambil total checkin pada bulan sebelumnya
        $prevMonthTotal = $builder->select('COUNT(*) as total')
            ->where('MONTH(created_at)', date('m') - 1)
            ->get()->getRow()->total;

        if ($prevMonthTotal > 0) {

            // Mengambil total checkin pada bulan ini
            $thisMonthTotal = $builder->select('COUNT(*) as total')
                ->where('MONTH(created_at)', date('m'))
                ->get()->getRow()->total;

            // Menghitung persentase kenaikan
            $percentageIncrease = (($thisMonthTotal - $prevMonthTotal) / $prevMonthTotal) * 100;

            // Memformat hasil persentase
            $formattedPercentageIncrease = number_format($percentageIncrease, 0);

                return [
                    'total' => $formattedPercentageIncrease
                ];
          
        } else {
              return [
                    'total' => 0
                ];
           
        }
    }


    public function users()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->select('COUNT(*) as users');
        $query = $builder->get()->getResult();
        return $query;
    }

    public function roles()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('roles');
        $builder->select('*');
        $query = $builder->get()->getResult();
        return $query;
    }
}