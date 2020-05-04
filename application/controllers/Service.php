<?php
use Restserver \Libraries\REST_Controller; 
require(APPPATH . 'libraries/REST_Controller.php');

Class Service extends REST_Controller{
    public function __construct(){ 
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, OPTIONS, POST, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Content- Length, Accept-Encoding");
        parent::__construct(); 
        $this->load->model('ServiceModel'); 
        $this->load->library('form_validation');
    }

    public function index_get(){
        return $this->returnData($this->db->get('service')->result(), false);
    }

    public function index_post($id = null){
        $validation = $this->form_validation; 
        $rule = $this->ServiceModel->rules(); 
        if($id == null){
            array_push($rule,
                    [ 
                        'field' => 'jenis',  
                        'label' => 'jenis',
                        'rules' => 'required'
                    ],
                    [ 
                        'field' => 'lama',  
                        'label' => 'lama',
                        'rules' => 'required'
                    ],
                    [ 
                        'field' => 'harga',  
                        'label' => 'harga',
                        'rules' => 'required|numeric'
                    ],
                    [ 
                        'field' => 'deskripsi',  
                        'label' => 'deskripsi',
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
                        'field' => 'jenis',  
                        'label' => 'jenis',
                        'rules' => 'required'
                    ],
                    [ 
                        'field' => 'lama',  
                        'label' => 'lama',
                        'rules' => 'required'
                    ],
                    [ 
                        'field' => 'harga',  
                        'label' => 'harga',
                        'rules' => 'required|numeric'
                    ],
                    [ 
                        'field' => 'deskripsi',  
                        'label' => 'deskripsi',
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
            $service = new UserData();
            $service->jenis = $this->post('jenis'); 
            $service->lama = $this->post('lama'); 
            $service->harga = $this->post('harga'); 
            $service->deskripsi = $this->post("deskripsi");
            $service->link = $this->post("link");

            if($id == null){
                $response = $this->ServiceModel->store($service);
            }else{
                $response = $this->ServiceModel->update($service,$id);
            }
            return $this->returnData($response['msg'],$response['error']); 
    }

    public function index_delete($id = null){ 
        if($id == null){
            return $this->returnData('Parameter Id Tidak Ditemukan', true); 
        }
        $response = $this->ServiceModel->destroy($id);
        return $this->returnData($response['msg'], $response['error']);
    }

    public function returnData($msg,$error){
        $response['error']=$error; 
        $response['message']=$msg;
        return $this->response($response);
    } 
}

Class UserData{
    public $jenis;
    public $lama;
    public $harga;
    public $deskripsi;
    public $link;
}

