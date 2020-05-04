<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MobilModel extends CI_Model {
    private $table = 'mobil';
    public $id; 
    public $nama; 
    public $merk; 
    public $am; 
    public $harga;
    public $link;
    public $rule = [
    [   
        'field' => 'nama', 
        'label' => 'nama',
        'rules' => 'required' ],
    ];
    public function Rules() { return $this->rule; }
    public function getAll() { return $this->db->get('data_mobil')->result();
    }

    public function store($request) {
        $this->nama = $request->nama;
        $this->merk = $request->merk;
        $this->am = $request->am;
        $this->harga = $request->harga;
        $this->link = $request->link;
        if($this->db->insert($this->table, $this)){
            return ['msg'=>'Berhasil','error'=>false];
    }
    else
            return ['msg'=>'Gagal','error'=>true]; }
    public function update($request,$id) {

        $queryNama = "SELECT nama FROM mobil WHERE id = $id LIMIT 1";
        
       

        $updateData = 
        ['nama' => $request->nama, 
        'merk' =>$request->merk,
        'am' =>$request->am,
        'harga' =>$request->harga,
        'link' =>$request->link
        ]; 
        $queryUpCart = "UPDATE cartKendaraan SET nama = ? , merk = ? , am = ? , harga = ? WHERE nama = $queryNama ";
        
        if($this->db->where('id',$id)->update($this->table, $updateData)){
            return ['msg'=>'Berhasil','error'=>false]; 
        }
        return ['msg'=>'Gagal','error'=>true]; 
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
