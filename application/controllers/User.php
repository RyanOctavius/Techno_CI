<?php
    use Restserver \Libraries\REST_Controller ; 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    defined('BASEPATH') OR exit('No direct script access allowed');
    require APPPATH . '/libraries/REST_Controller.php';
    require 'vendor/autoload.php';


    class User extends \Restserver\Libraries\REST_Controller 
    {
        public function __construct() 
        {
         header('Access-Control-Allow-Origin: *');
      header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

            parent::__construct();
            $this->load->model('UserModel','User');
            $this->load->helper('string');
        }


        public function index_get($username = null)
        {
            if ($username == null)
                $data = $this->User->getAll();
            else
                $data = $this->User->getAll('username', $username);
            
            $this->response([
                'status' => TRUE,
                'message' => 'Success',
                'data' => $data
            ], \Restserver\Libraries\REST_Controller::HTTP_OK);
        }


        public function index_post() 
        {
            $username = $this->post('username');
            $email = $this->post('email');
            $password = password_hash($this->post('password'), PASSWORD_DEFAULT);
            $noTelp = $this->post('noTelp');
            

            $temp = $this->User->getAll('email', $email);

            if ($temp != null) {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Email Sudah Terdaftar!',
                    'data' => $temp
                ], \Restserver\Libraries\REST_Controller::HTTP_BAD_REQUEST);
            } else if ($username != null && $password != null && $email != null && $noTelp != null) {
                    $data = [
                        
                        'username' => $username,
                        'email' => $email,
                        'password' => $password,                        
                        'noTelp' => $noTelp,
                        'role' => 'user',
                        'status' => 0
                    ];
                    $hash = base64_encode($email);
                    $mail = new PHPMailer(true);
                    try {
                        //Server settings
                        $mail->SMTPDebug = 0;                                 // Enable verbose debug output
                        $mail->isSMTP();                                      // Setmailer touse SMTP
                        $mail->Host = 'smtp.gmail.com';  // Specify main andbackup SMTP servers
                        $mail->SMTPAuth = true;                               // Enable SMTP authentication
                        $mail->Username = 'tumbalios1@gmail.com';                 // SMTP username
                        $mail->Password= 'terserah123';                           // SMTP password
                        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, ssl also accepted
                        $mail->Port = 465;                                    // TCP port toconnectto
                        //Recipients
                        $mail->setFrom('dewantaps@gmail.com', 'PAW');
                        $mail->addAddress($email, $username);     // Adda recipient
                        //$mail->addAddress('ellen@example.com');               // Nameisoptional
                        //$mail->addReplyTo('info@example.com', 'Information');
                        //$mail->addCC('cc@example.com');
                        //$mail->addBCC('bcc@example.com');
                        //Attachments
                        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Addattachments
                        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
                        //Content
                        $mail->isHTML(true);                                  // Setemail format toHTML
                        $mail->Subject = 'Verification Email';
                        $mail->Body = 
                        "
                            <p>Setelah melakukan pendaftaran akun user <strong>PAWTOMATIVE</strong>, 
                            lakukan <b>AKTIVASI</b> akun Anda dengan mengklik 
                            tautan berikut : </p><br>".base_url()."verifikasi/$hash
                        ";
                        if ($mail->send()) {
                            if ($this->User->createUser($data) > 0) {
                                $this->response([
                                    'status' => TRUE,
                                    'message' => 'Berhasil',
                                    'data' => $data
                                ], \Restserver\Libraries\REST_Controller::HTTP_OK);
                            } else {
                                $this->response([
                                    'status' => FALSE,
                                    'message' => 'Gagal!'
                                ], \Restserver\Libraries\REST_Controller::HTTP_BAD_REQUEST);
                            }
                        } else {
                            $this->response([
                                'status' => FALSE,
                                'message' => 'Koneksi Error!'
                            ], \Restserver\Libraries\REST_Controller::HTTP_BAD_REQUEST);
                        }
                    }catch (Exception $e) {
                        $response = ['msg' => "cant send email", "error"=> true];
                    }
                    
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Inputan Tidak Ditemukan!'
                ], \Restserver\Libraries\REST_Controller::HTTP_NOT_FOUND);
            }
        }


        public function index_delete() 
        {
            $id = $this->delete('id');

            if ($id != null) {
                $data = $this->User->getAll('id', $id);

                if ($this->User->deleteUser($id) > 0) {
                    $this->response([
                        'status' => TRUE,
                        'message' => 'Berhasil',
                        'data' => $data
                    ], \Restserver\Libraries\REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'ID Tidak Ditemukan!'
                    ], \Restserver\Libraries\REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Inputan Tidak Ditemukan!'
                ], \Restserver\Libraries\REST_Controller::HTTP_NOT_FOUND);
            }
        }


        public function edit_post($nama)
        {
            $username = $this->post('username');
            $email = $this->post('email');
            $password =  password_hash($this->post('password'), PASSWORD_DEFAULT);
            $noTelp = $this->post('noTelp');
            if ($username != null && $email != null && $noTelp != null && $password != null) {
                    $data = [
                        'username' => $username,
                        'email' => $email,
                        'noTelp' => $noTelp,
                        'password' => $password
                    ];

                    if ($this->User->updateUser($data, $nama) > 0) {
                        $this->response([
                            'status' => TRUE,
                            'message' => 'Berhasil',
                            'data' => $data
                        ], \Restserver\Libraries\REST_Controller::HTTP_OK);
                    } else {
                        $this->response([
                            'status' => FALSE,
                            'message' => 'Username Tidak Ditemukan!'
                        ], \Restserver\Libraries\REST_Controller::HTTP_BAD_REQUEST);
                    }
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Inputan Tidak Ditemukan!'
                ], \Restserver\Libraries\REST_Controller::HTTP_NOT_FOUND);
            }
        }


        public function login_post() {
            $username = $this->post('username');
            $password = $this->post('password');

            if ($this->User->loginUser($username, $password) > 0) {
                $this->response([
                    'status' => TRUE,
                    'message' => 'Berhasil',
                    'data' => $this->User->getAll('username', $username)
                ], \Restserver\Libraries\REST_Controller::HTTP_OK);
            } else if ($this->User->loginUser($username, $password) == -1) {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Username Tidak Terdaftar!'
                ], \Restserver\Libraries\REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Username / Kata Sandi Salah!'
                ], \Restserver\Libraries\REST_Controller::HTTP_NOT_FOUND);
            }
        }


        public function verifikasi_get() {
            $email = $this->get('email');
            $kode = $this->get('kode');

            if ($this->User->verifikasiEmail($email, $id) > 0) {
                $this->response([
                    'status' => TRUE,
                    'message' => 'Berhasil'
                ], \Restserver\Libraries\REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Gagal!'
                ], \Restserver\Libraries\REST_Controller::HTTP_NOT_FOUND);
            }
        }

        public function returnData($msg,$error){
            $response['error']=$error; 
            $response['message']=$msg;
            return $this->response($response);
        } 
    }


?>