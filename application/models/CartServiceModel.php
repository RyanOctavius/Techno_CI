<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CartServiceModel extends CI_Model {
    private $table = 'cartService';
    public $id; 
    public $jenis; 
    public $lama; 
    public $harga;
    public $username;
    public $tanggal;
    public $rule = [
    [   
        'field' => 'jenis', 
        'label' => 'jenis',
        'rules' => 'required' ],
    ];
    public function Rules() { return $this->rule; }
    public function getAll() { return $this->db->get('cart_service')->result();
    }

    public function store($request) {
        $this->jenis = $request->jenis;
        $this->lama = $request->lama;
        $this->harga = $request->harga;
        $this->username = $request->username;
        $this->tanggal = gettimeofday();
        if($this->db->insert($this->table, $this)){
            return ['msg'=>'Berhasil','error'=>false];
        }
        else
            return ['msg'=>'Gagal','error'=>true]; 
        }

    public function update($request,$id) {
        $updateData = 
        ['jenis' => $request->jenis, 
        'lama' =>$request->lama,
        'harga' =>$request->harga,
        'username' =>$request->username,
        'tanggal'=> gettimeofday()
        ]; 
        if($this->db->where('id',$id)->update($this->table, $updateData)){
            return ['msg'=>'Berhasil','error'=>false]; 
        }
        return ['msg'=>'Gagal','error'=>true]; 
    }

    public function searchUser($username){
        $this->username = $username;
        $query =  "SELECT * FROM cartService WHERE username = ?" ;
        $result = $this->db->query($query, $this->username);
        if($result->num_rows() != 0){
            return ['msg'=> $result->result() ,'error'=>false];
        }
        else{
            return ['msg'=>'Data Tidak Ditemukan','error'=>true];
        }
    }

    public function destroy($id){
    if (empty($this->db->select('*')->where(array('id' => $id))->get($this->table)->row())) 
        return ['msg'=>'Id tidak ditemukan','error'=>true];
    if($this->db->delete($this->table, array('id' => $id))){ 
        return ['msg'=>'Berhasil','error'=>false];
    }
    return ['msg'=>'Gagal','error'=>true]; 
    }
}
?>
