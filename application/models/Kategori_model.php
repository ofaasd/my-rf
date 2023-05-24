<?php
Class Kategori_model extends CI_Model{
    public $nama;

    public function get_all()
    {
            $query = $this->db->get('ref_kategori');
            return $query->result();
    }

    public function get_by_id($id)
    {
            $query = $this->db->where('id',$id)->get('ref_kategori');
            return $query->row();
    }
    
    public function insert(){
        $this->nama = $_POST['nama'];
        if($this->db->insert('ref_kategori',$this)){
            return true;
        }else{
            return false;
        }
        
    }

    public function update(){
        $this->nama = $_POST['nama'];

        if($this->db->update('ref_kategori', $this, array('id' => $_POST['id']))){
            return true;
        }else{
            return false;
        }
    }

    public function delete($id)
    {
        if($this->db->delete('ref_kategori', array('id' => $id))){
            return true;
        }else{
            return false;
        }
    }
}