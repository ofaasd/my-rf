<?php
Class Jenis_model extends CI_Model{
    // public $title;
    // public $content;
    // public $date;
    public $jenis;

    public function get_all()
    {
            $query = $this->db->order_by('urutan','asc')->get('ref_jenis_pembayaran');
            return $query->result();
    }
	public function get_cat_tunggakan(){
			$jenis = array('1','16');
			$query = $this->db->where_in("id",$jenis)->order_by('urutan','asc')->get('ref_jenis_pembayaran');
            return $query->result();
	}
    public function get_by_id($id)
    {
            // $this->title    = $_POST['title']; // please read the below note
            // $this->content  = $_POST['content'];
            // $this->date     = time();

            //$this->db->insert('entries', $this);
            $query = $this->db->where('id',$id)->get('ref_jenis_pembayaran');
            return $query->row();
    }
    
    public function insert(){
        $this->jenis = $_POST['jenis'];
        if($this->db->insert('ref_jenis_pembayaran',$this)){
            return true;
        }else{
            return false;
        }
        
    }

    public function update(){
        $this->jenis = $_POST['jenis'];

        if($this->db->update('ref_jenis_pembayaran', $this, array('id' => $_POST['id']))){
            return true;
        }else{
            return false;
        }
    }

    public function delete($id)
    {
        if($this->db->delete('ref_jenis_pembayaran', array('id' => $id))){
            return true;
        }else{
            return false;
        }
    }
}