<?php 
use Restserver \Libraries\REST_Controller; 
require(APPPATH . 'libraries/REST_Controller.php');

class Verifikasi extends REST_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('UserModel');
	}

	public function index_get($email) {
		
		$model=$this->UserModel->verifikasiEmail($email);

		if ( $model==0) {
			echo "Verifikasi gagal";
		}
		else {
			echo "Selamat verifikasi akun berhasil";
		}
	}
}