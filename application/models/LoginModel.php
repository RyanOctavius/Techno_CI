<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginModel extends CI_Model {
    private $table = 'user';
    public $id; 
    public $username; 
    public $email; 
    public $password;
    public $noTelp; 
    public $rule = [
        [ 
            'field' => 'username',  
            'label' => 'username',
            'rules' => 'required'
        ]
    ];
    public function Rules() { return $this->rule; }
    public function getAll() { return $this->db->get('data_user')->result();
    }

    //untuk cek username dan password
    public function check_login($request) {
        $this->username = $request->username;
        $this->password =$request->password;
        $query = "SELECT * FROM user WHERE username = ? LIMIT 1" ;
        $result = $this->db->query($query, $this->username);
        if($result->num_rows() != 0)
        {
            $hash = $result->row()->password;
            if(password_verify($this->password, $hash)){
                return ['msg'=>'Berhasil','error'=>false]; 
            }
            else{
                return ['msg'=>'Password salah','error'=>true];
            }
        }
        else{
            return ['msg'=>'Username tidak ada','error'=>true];
        }
    }
       
    public function getInfo($username){
        $this->username = $username;
        $query =  "SELECT * FROM user WHERE username = ?" ;
        $result = $this->db->query($query, $this->username );
        if($result->num_rows() != 0){
            return ['msg'=> $result->result() ,'error'=>false];
        }
        else{
            return ['msg'=>'Data Tidak Ditemukan','error'=>true];
        }
    }

    public function update($id) {
        $updateData = [
        'active' => '1'
        ]; 
        if($this->db->where('id',$id)->update($this->table, $updateData)){
            return ['msg'=>'Berhasil','error'=>false]; 
        }
        return ['msg'=>'Gagal','error'=>true]; 
    }

    public function destroy($id){
        $updateData = [
            'active' => '0'
            ]; 
            if($this->db->where('id',$id)->update($this->table, $updateData)){
                return ['msg'=>'Berhasil','error'=>false]; 
            }
            return ['msg'=>'Gagal','error'=>true]; 
    }
}
?>
