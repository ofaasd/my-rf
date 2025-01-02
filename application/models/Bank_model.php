<?php
Class Bank_model extends CI_Model{
    public $nama;

    public function get_all()
    {
            $query = $this->db->order_by('nama','asc')->get('ref_bank');
            return $query->result();
    }

    public function get_by_id($id)
    {
            $query = $this->db->where('id',$id)->get('ref_bank');
            return $query->row();
    }
    
    public function insert(){
        $this->nama = $_POST['nama'];
        if($this->db->insert('ref_bank',$this)){
            return true;
        }else{
            return false;
        }
        
    }

    public function update(){
        $this->nama = $_POST['nama'];

        if($this->db->update('ref_bank', $this, array('id' => $_POST['id']))){
            return true;
        }else{
            return false;
        }
    }

    public function delete($id)
    {
        if($this->db->delete('ref_bank', array('id' => $id))){
            return true;
        }else{
            return false;
        }
    }
}