<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ServiceModel extends CI_Model {
    private $table = 'service';
    public $id; 
    public $jenis; 
    public $lama; 
    public $harga;
    public $deskripsi;
    public $link;
    public $rule = [
    [   
        'field' => 'jenis', 
        'label' => 'jenis',
        'rules' => 'required' ],
    ];
    public function Rules() { return $this->rule; }
    public function getAll() { return $this->db->get('data_service')->result();
    }

    public function store($request) {
        $this->jenis = $request->jenis;
        $this->lama = $request->lama;
        $this->harga = $request->harga;
        $this->deskripsi = $request->deskripsi;
        $this->link = $request->link;
        if($this->db->insert($this->table, $this)){
            return ['msg'=>'Berhasil','error'=>false];
    }
    else
            return ['msg'=>'Gagal','error'=>true]; }
    public function update($request,$id) {
        $updateData = 
        ['jenis' => $request->jenis, 
        'lama' =>$request->lama,
        'harga' =>$request->harga,
        'deskripsi' =>$request->deskripsi,
        'link' =>$request->link
        ]; 
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
