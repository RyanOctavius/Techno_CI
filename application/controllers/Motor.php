<?php
use Restserver \Libraries\REST_Controller; 
require(APPPATH . 'libraries/REST_Controller.php');

Class Motor extends REST_Controller{
    public function __construct(){ 
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, OPTIONS, POST, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Content- Length, Accept-Encoding");
        parent::__construct(); 
        $this->load->model('MotorModel'); 
        $this->load->library('form_validation');
    }

    public function index_get(){
        return $this->returnData($this->db->get('motor')->result(), false);
    }

    public function index_post($id = null){
        $validation = $this->form_validation; 
        $rule = $this->MotorModel->rules(); 
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
                        'rules' => 'required'
                    ],
                    [
                        'field' => 'link',  
                        'label' => 'link',
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
                        'field' => 'link',  
                        'label' => 'link',
                        'rules' => 'required'
                    ]
                );
            }
            $validation->set_rules($rule); 
            if (!$validation->run()) {
                return $this->returnData($this->form_validation->error_array(), true);
            }
            $motor = new UserData();
            $motor->nama = $this->post('nama'); 
            $motor->merk = $this->post('merk'); 
            $motor->am = $this->post('am'); 
            $motor->harga = $this->post('harga'); 
            $motor->link = $this->post('link');
            if($id == null){
                $response = $this->MotorModel->store($motor);
            }else{
                $response = $this->MotorModel->update($motor,$id);
            }
            return $this->returnData($response['msg'],$response['error']); 
    }

    public function index_delete($id = null){ 
        if($id == null){
            return $this->returnData('Parameter Id Tidak Ditemukan', true); 
        }
        $response = $this->MotorModel->destroy($id);
        return $this->returnData($response['msg'], $response['error']);
    }

    public function returnData($msg,$error){
        $response['error']=$error; 
        $response['message']=$msg;
        return $this->response($response);
    } 
}

Class UserData{
    public $nama;
    public $merk;
    public $am;
    public $harga;
    public $link;
}