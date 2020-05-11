<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CartKendaraanModel extends CI_Model {
    private $table = 'cartKendaraan';
    public $id; 
    public $nama; 
    public $merk; 
    public $harga;
    public $am;
    public $username;
    public $tanggal;
    public $rule = [
    [   
        'field' => 'username', 
        'label' => 'username',
        'rules' => 'required' ],
    ];
    public function Rules() { return $this->rule; }
    public function getAll() { return $this->db->get('cartKendaraan')->result();
    }

    public function store($request) {
        $this->nama = $request->nama;
        $this->merk = $request->merk;
        $this->harga = $request->harga;
        $this->am = $request->am;
        $this->username = $request->username;
        $this->tanggal = $request->tanggal;
        if($this->db->insert($this->table, $this)){
            return ['msg'=>'Berhasil','error'=>false];
        }
        else
            return ['msg'=>'Gagal','error'=>true]; }
    public function update($request,$id) {
        $updateData = 
        ['nama' => $request->nama, 
        'merk' =>$request->merk,
        'harga' =>$request->harga,
        'am'=>$request->am,
        'username' =>$request->username,
        'tanggal'=> date("Y-m-d H:i:s")
        ]; 
        if($this->db->where('id',$id)->update($this->table, $updateData)){
            return ['msg'=>'Berhasil','error'=>false]; 
        }
        return ['msg'=>'Gagal','error'=>true]; 
    }

    public function searchUser($username){
        $this->username = $username;
        $query =  "SELECT * FROM cartKendaraan WHERE username = ?" ;
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
