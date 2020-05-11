<?php
use Restserver \Libraries\REST_Controller; 
require(APPPATH . 'libraries/REST_Controller.php');

Class CartKendaraan extends REST_Controller{
    public function __construct(){ 
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, OPTIONS, POST, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Content- Length, Accept-Encoding");
        parent::__construct(); 
        $this->load->model('CartKendaraanModel'); 
        $this->load->library('form_validation');
    }

    public function index_get(){
            $this->returnData($this->db->get('cartKendaraan')->result(), false);
    }

    public function index_post($id = null){
        $validation = $this->form_validation; 
        $rule = $this->CartKendaraanModel->rules(); 
        if($id == null){
            array_push($rule,
                    [ 
                        'field' => 'nama',  
                        'label' => 'nama',
                        'rules' => 'required'
                    ],
                    [
                        'field' => 'merk',  
                        'label' => 'merk',
                        'rules' => 'required'
                    ],
                    [ 
                        'field' => 'am',  
                        'label' => 'am',
                        'rules' => 'required'
                    ],
                    [
                        'field' => 'harga',  
                        'label' => 'harga',
                        'rules' => 'required|numeric'
                    ],
                    [
                        'field' => 'username',  
                        'label' => 'username',
                        'rules' => 'required'
                    ]
                );
            } 
            else{
                    array_push($rule,
                    [ 
                        'field' => 'nama',  
                        'label' => 'nama',
                        'rules' => 'required'
                    ],
                    [ 
                        'field' => 'merk',  
                        'label' => 'merk',
                        'rules' => 'required'
                    ],
                    [ 
                        'field' => 'am',  
                        'label' => 'am',
                        'rules' => 'required'
                    ],
                    [ 
                        'field' => 'harga',  
                        'label' => 'harga',
                        'rules' => 'required'
                    ],
                    [
                        'field' => 'username',  
                        'label' => 'username',
                        'rules' => 'required'
                    ]
                );
            }
            $validation->set_rules($rule); 
            if (!$validation->run()) {
                return $this->returnData($this->form_validation->error_array(), true);
            }
            $kendaraan = new UserData();
            $kendaraan->nama = $this->post('nama'); 
            $kendaraan->merk = $this->post('merk'); 
            $kendaraan->harga = $this->post('harga'); 
            $kendaraan->am = $this->post('am'); 
            $kendaraan->username = $this->post("username");
            date_default_timezone_set("Asia/Jakarta");
            $now = date("Y-m-d H:i:s");
            $kendaraan->tanggal = $now;
            if($id == null){
                $response = $this->CartKendaraanModel->store($kendaraan);
            }else{
                $response = $this->CartKendaraanModel->update($kendaraan,$id);
            }
            return $this->returnData($response['msg'],$response['error']); 
    }

    public function index_delete($id = null){ 
        if($id == null){
            return $this->returnData('Parameter Id Tidak Ditemukan', true); 
        }
        $response = $this->CartKendaraanModel->destroy($id);
        return $this->returnData($response['msg'], $response['error']);
    }

    public function returnData($msg,$error){
        $response['error']=$error; 
        $response['message']=$msg;
        return $this->response($response);
    } 

    public function show_get($username){
        if($username == null){
            return $this->returnData('Parameter Username Tidak Ditemukan', true); 
        }
        else{
            print($username);
            return $this->returnData($this->CartKendaraanModel->searchUser($username),false);
        }
    }
}

Class UserData{
    public $nama;
    public $merk;
    public $harga;
    public $am;
    public $username;
    public $tanggal;
}