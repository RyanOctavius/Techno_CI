<?php
use Restserver \Libraries\REST_Controller; 
require(APPPATH . 'libraries/REST_Controller.php');

Class Avatar extends REST_Controller {
    
    public function __construct(){ 
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, OPTIONS, POST, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Content- Length, Accept-Encoding");
        parent::__construct(); 
        $this->load->model('UserModel'); 
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function index_post($username = null){
        // $user = new UserData();
        // $user->image = $this->post('image'); 
            $response = $this->UserModel->upload($username);
            
            return $this->returnData($response['msg'],$response['error']); 
    
    }

    public function index_delete($id = null){ 
        //tidak ada delete
    }

    public function returnData($msg,$error){
        $response['error']=$error; 
        $response['message']=$msg;
        return $this->response($response);
    } 
    
}

Class UserData{
    public $username;
    public $password;
    public $email;
    public $noTelp;
    public $role;
    public $image;
}
