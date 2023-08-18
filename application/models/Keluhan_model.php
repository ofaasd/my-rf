<?php
Class Keluhan_model extends CI_Model{

    public function get_all()
    {
            $query = $this->db->order_by('id','desc')->where('is_hapus',0)->get('tb_keluhan');
            return $query->result();
    }
    public function get_by_date($start,$end)
    {
            $query = $this->db->order_by('id','desc')->where('is_hapus',0)->where('created_at >=', $start)->where('created_at <=', $end)->get('tb_keluhan');
            return $query->result();
    }

    public function get_by_id($id)
    {
            $query = $this->db->where('id',$id)->get('tb_keluhan');
            return $query->row();
    }
    
    
    public function insert(){
        
        $data = array(
            'nama_pelapor' => $this->input->post('nama_pelapor'),
            'email' => $this->input->post('email'),
            'no_hp' => $this->input->post('no_hp'),
            'id_santri' => $this->input->post('nama_santri'),
            'nama_wali_santri' => $this->input->post('nama_wali_santri'),
            'id_kategori' => $this->input->post('kategori'),
            'masukan' => $this->input->post('masukan'),
            'saran' => $this->input->post('saran'),
            'rating' => $this->input->post('rating'),
            'jenis' => $this->input->post('jenis'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        );
        
        if($this->db->insert('tb_keluhan',$data)){
            return true;
        }else{
            return false;
        }
        
    }

    public function update(){
        $data = array(
            'nama_pelapor' => $this->input->post('nama_pelapor'),
            'email' => $this->input->post('email'),
            'no_hp' => $this->input->post('no_hp'),
            'id_santri' => $this->input->post('id_santri'),
            'nama_wali_santri' => $this->input->post('nama_wali_santri'),
            'id_kategori' => $this->input->post('id_kategori'),
            'masukan' => $this->input->post('masukan'),
            'saran' => $this->input->post('saran'),
            'rating' => $this->input->post('rating'),
            'jenis' => $this->input->post('jenis'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        );

        if($this->db->update('tb_keluhan', $this, array('id' => $this->input->post('id')))){
            return true;
        }else{
            return false;
        }
    }

    public function delete($id)
    {
        if($this->db->update('tb_keluhan',array('is_hapus'=>1), array('id' => $id))){
            return true;
        }else{
            return false;
        }
    }
}
