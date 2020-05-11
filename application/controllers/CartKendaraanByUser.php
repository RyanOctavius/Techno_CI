<?php
use Restserver \Libraries\REST_Controller; 
require(APPPATH . 'libraries/REST_Controller.php');

Class CartKendaraanByUser extends REST_Controller{
    public function __construct(){ 
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, OPTIONS, POST, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Content- Length, Accept-Encoding");
        parent::__construct(); 
        $this->load->model('CartKendaraanModel'); 
        $this->load->library('form_validation');
    }

    public function index_get($username = null){
        $response = $this->CartKendaraanModel->searchUser($username);
        return $this->returnData($response['msg'],$response['error']);
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
    public $harga;
    public $am;
    public $username;
    public $tanggal;
}