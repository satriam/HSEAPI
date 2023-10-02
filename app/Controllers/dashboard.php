<?php

namespace App\Controllers;


use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
// use CodeIgniter\Model;
use App\Models\DashboardModel;

class dashboard extends ResourceController
{
        public function index(){
        $userModel = new DashboardModel();
        $cc = $userModel->cc();
        $ca = $userModel->ca();
        $users = $userModel->users();
        $mergedArray = array_merge($cc, $ca, $users);
      
        return $this->respond($mergedArray);
        }
   

    public function kenaikancheckin()
    {
        $dashboardModel= new DashboardModel();
       $kenaikancheckin = $dashboardModel->kc();
       return $this->response->setJSON($kenaikancheckin);

    }

    public function persentase()
    {
        $dashboardModel= new DashboardModel();
       $persen = $dashboardModel->persentase();
       return $this->response->setJSON($persen);

    }



    public function roles()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('roles');
        $builder->select('*');
        $query = $builder->get()->getResult();
        return $this->response->setJSON($query);
    }

}