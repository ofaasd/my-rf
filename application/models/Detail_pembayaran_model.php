<?php
Class Detail_pembayaran_model extends CI_Model{
    public $nama;

    public function get_all()
    {
            $query = $this->db->get('tb_detail_pembayaran');
            return $query->result();
    }

    public function get_by_id($id)
    {
            $query = $this->db->where('id',$id)->get('tb_detail_pembayaran');
            return $query->row();
    }

    public function get_by_id_pembayaran($id)
    {
            $query = $this->db->where('id_pembayaran',$id)->get('tb_detail_pembayaran');
            return $query->result();
    }
	public function get_by_id_pembayaran_tunggakan($id)
    {
			$jenis = array('1','16');
            $query = $this->db->where_in('id_jenis_pembayaran',$jenis)->where('id_pembayaran',$id)->get('tb_detail_pembayaran');
            return $query->result();
    }
    
    public function insert(){
        
        
    }

    public function update(){
       
    }

    public function delete($id)
    {
        if($this->db->delete('tb_detail_pembayaran', array('id' => $id))){
            return true;
        }else{
            return false;
        }
    }
}