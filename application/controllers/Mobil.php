<?php
use Restserver \Libraries\REST_Controller; 
require(APPPATH . 'libraries/REST_Controller.php');
defined('BASEPATH') OR exit('No direct script access allowed');

Class Mobil extends REST_Controller {
    public function __construct(){ 
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, OPTIONS, POST, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Content- Length, Accept-Encoding");
        parent::__construct(); 
        $this->load->model('MobilModel'); 
        $this->load->library('form_validation');
    }

    public function index_get(){
        return $this->returnData($this->db->get('mobil')->result(), false);
    }

    public function index_post($id = null){
        $validation = $this->form_validation; 
        $rule = $this->MobilModel->rules(); 
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
                        'rules' => 'required|numeric'
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
            $mobil = new UserData();
            $mobil->nama = $this->post('nama'); 
            $mobil->merk = $this->post('merk'); 
            $mobil->am = $this->post('am'); 
            $mobil->harga = $this->post('harga'); 
            $mobil->link = $this->post('link');
            
            if($id == null){
                $response = $this->MobilModel->store($mobil);
            }else{
                $response = $this->MobilModel->update($mobil,$id);
            }
            return $this->returnData($response['msg'],$response['error']); 
    }

    public function index_delete($id = null){ 
        if($id == null){
            return $this->returnData('Parameter Id Tidak Ditemukan', true); 
        }
        $response = $this->MobilModel->destroy($id);
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