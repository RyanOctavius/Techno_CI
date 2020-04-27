<?php
use Restserver \Libraries\REST_Controller; 
require(APPPATH . 'libraries/REST_Controller.php');

Class Login extends REST_Controller {
    
    public function __construct(){ 
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, OPTIONS, POST, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Content- Length, Accept-Encoding");
        parent::__construct(); 
        $this->load->model('LoginModel'); 
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index_get($username = null)
    {
        $response = $this->LoginModel->getInfo($username);
        return $this->returnData($response['msg'],$response['error']);
    }

    public function index_post(){
        $user = new UserData();
        $user->username = $this->post('username');
        $user->password = $this->post('password'); 
        $user->id = $this->post('id');
        $response = $this->LoginModel->check_login($user);

        return $this->returnData($response['msg'], $response['error']);
    }

    public function index_delete($id = null){ 
        if($id == null){
            return $this->returnData('Parameter Id Tidak Ditemukan', true); 
        }
        $response = $this->LoginModel->destroy($id);
        return $this->returnData($response['msg'], $response['error']);
    }

    public function returnData($msg,$error){
        $response['error']=$error; 
        $response['message']=$msg;
        return $this->response($response);
    } 
    
}

Class UserData{
    public $id;
    public $email;
    public $username;
    public $password;
}
