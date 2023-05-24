<?php
Class Keringanan_model extends CI_Model{
    public $id_siswa;
    public $id_jenis_pembayaran;
    public $harga;

    public function get_all()
    {
		$query = $this->db
					  ->select('tb_jenis_pembayaran_exception.*,ref_siswa.nama,ref_jenis_pembayaran.jenis')
					  ->join('ref_siswa','ref_siswa.id = tb_jenis_pembayaran_exception.id_siswa','inner')
					  ->join('ref_jenis_pembayaran', 'ref_jenis_pembayaran.id = tb_jenis_pembayaran_exception.id_jenis_pembayaran','inner')
					  ->order_by('id','desc')
					  ->get('tb_jenis_pembayaran_exception');
		return $query->result();
    }
	public function get_all2()
	{
		$query = $this->db->get('tb_jenis_pembayaran_exception');
		return $query->result();
	}
    public function get_by_id_siswa($id_siswa)
    {
            $query = $this->db->where('id_siswa',$id_siswa)->get('tb_jenis_pembayaran_exception');
            return $query->result();
    }
	public function get_by_jenis($id_jenis)
	{
			$query = $this->db->where('id_jenis_pembayaran',$id_jenis)->get('tb_jenis_pembayaran_exception');
            return $query->result();
	}
    public function get_by_id($id)
    {
            $query = $this->db->select('tb_jenis_pembayaran_exception.*,ref_siswa.nama,ref_siswa.kode,ref_jenis_pembayaran.jenis')
						  ->join('ref_siswa','ref_siswa.id = tb_jenis_pembayaran_exception.id_siswa','inner')
						  ->join('ref_jenis_pembayaran', 'ref_jenis_pembayaran.id = tb_jenis_pembayaran_exception.id_jenis_pembayaran','inner')
						  ->where('tb_jenis_pembayaran_exception.id',$id)->get('tb_jenis_pembayaran_exception');
            return $query->row();
    }

    public function insert(){
		
        $this->id_siswa = $this->input->post('id_siswa');
        $this->id_jenis_pembayaran = $this->input->post('id_jenis');
        $this->harga = str_replace(".", "", $this->input->post('harga'));
        if($this->db->insert('tb_jenis_pembayaran_exception',$this)){
            return true;
        }else{
            return false;
        }
        
    }

    public function update(){
        $this->id_siswa = $this->input->post('id_siswa');
        $this->id_jenis_pembayaran = $this->input->post('id_jenis');
        $this->harga = str_replace(".", "", $this->input->post('harga'));

        if($this->db->update('tb_jenis_pembayaran_exception', $this, array('id' => $_POST['id']))){
            return true;
        }else{
            return false;
        }
    }

    public function delete($id)
    {
        if($this->db->delete('tb_jenis_pembayaran_exception', array('id' => $id))){
            return true;
        }else{
            return false;
        }
    }
}