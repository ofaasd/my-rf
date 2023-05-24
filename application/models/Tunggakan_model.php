<?php
Class Tunggakan_model extends CI_Model{
    public $nama;

    public function get_all()
    {
            $query = $this->db->order_by("id","desc")->where("is_hapus",0)->get('tb_tunggakan');
            return $query->result();
    }

    public function get_by_id($id)
    {
        $query = $this->db->select("tb_tunggakan.*,ref_siswa.nama,ref_siswa.kode,ref_jenis_pembayaran.jenis")->join("ref_siswa","ref_siswa.id=tb_tunggakan.id_siswa")->join("ref_jenis_pembayaran","ref_jenis_pembayaran.id=tb_tunggakan.id_jenis_pembayaran")->where('tb_tunggakan.id',$id)->get('tb_tunggakan');
        return $query->row();
    }
    public function get_by_bulan($bulan,$tahun){
		$where = array();
		if($bulan == 0){
			$where = array(
				'tahun'=>$tahun,
				'is_hapus'=>0
			);
		}else{
			$where = array(
				'bulan'=>$bulan,
				'tahun'=>$tahun,
				'is_hapus'=>0
			);
		}
        $query = $this->db->order_by("id asc")->where($where)->get('tb_tunggakan');
        return $query->result();
    }
	public function get_by_santri($nama_santri){
		$query = $this->db->select("tb_tunggakan.*,ref_siswa.nama,ref_siswa.kode,ref_jenis_pembayaran.jenis")->join("ref_siswa","ref_siswa.id=tb_tunggakan.id_siswa")->join("ref_jenis_pembayaran","ref_jenis_pembayaran.id=tb_tunggakan.id_jenis_pembayaran")->where(['id_siswa'=>$nama_santri,'is_hapus'=>0])->get('tb_tunggakan');
        return $query->result();
	}
	public function get_all_tunggakan($nama_santri){
		$query = $this->db->where(['id_siswa'=>$nama_santri,'is_hapus'=>0,'status'=>0])->get('tb_tunggakan');
        $hasil = 0;
		foreach($query->result() as $row){
			$hasil += ($row->kekurangan-$row->pembayaran);
		}
		return $hasil;
	}
	public function get_by_santri_bulan($nama_santri, $bulan){
		$query = $this->db->where(['id_siswa'=>$nama_santri,'is_hapus'=>0,'bulan'=>$bulan])->get('tb_tunggakan');
        return $query->result();
	}
    
    public function insert(){
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
		$id_siswa = $this->input->post('id_siswa');
		$id_jenis = $this->input->post('id_jenis');
		$kekurangan = $this->input->post('kekurangan');
		$hasil = 0;
		//bershkan data pada tabel terlebih dahulu
		$data = array(
			'bulan' => $bulan,
			'tahun' => $tahun,
		);
		$hapus = $this->db->delete('tb_tunggakan',$data);
		foreach($id_siswa as $key=>$value){
			$data = array(
				'id_siswa' => $value,
				'id_jenis_pembayaran' => $id_jenis[$key],
				'bulan' => $bulan,
				'tahun' => $tahun,
				'kekurangan' => $kekurangan[$key],
				'status' => 0,
				'is_hapus' => 0,
			);
			$query = $this->db->insert('tb_tunggakan',$data);
			if($query){
				$hasil += 1;
			}
		}
		if($hasil == 0){
			return false;
		}else{
			return true;
		}
    }
	public function insert2(){
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
		$id_siswa = $this->input->post('nama_santri');
		$id_jenis = $this->input->post('jenis');
		$kekurangan = str_replace(".", "", $this->input->post('kekurangan'));
		$pembayaran = str_replace(".", "", $this->input->post('pembayaran'));
		$status = $this->input->post('status');
		$hasil = 0;
		//bershkan data pada tabel terlebih dahulu
		
		$data = array(
			'id_siswa' => $id_siswa,
			'id_jenis_pembayaran' => $id_jenis,
			'bulan' => $bulan,
			'tahun' => $tahun,
			'kekurangan' => $kekurangan,
			'pembayaran' => $pembayaran,
			'status' => $status,
			'is_hapus' => 0,
		);
		$query = $this->db->insert('tb_tunggakan',$data);
		if($query){
			$hasil = 1;
		}
		if($hasil == 0){
			return false;
		}else{
			return true;
		}
    }

    public function update(){
		
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
		$id_siswa = $this->input->post('nama_santri');
		$id_jenis = $this->input->post('jenis');
		$pembayaran = $this->input->post('pembayaran');
		$kekurangan = str_replace(".", "", $this->input->post('kekurangan'));
		$status = $this->input->post('status');
		$id = $this->input->post('id');
		$data = array(
			'id_siswa' => $id_siswa,
			'id_jenis_pembayaran' => $id_jenis,
			'bulan' => $bulan,
			'tahun' => $tahun,
			'kekurangan' => $kekurangan,
			'pembayaran' => $pembayaran,
			'status' => $status,
		);

        if($this->db->update('tb_tunggakan', $data, array('id' => $id))){
            return true;
        }else{
            return false;
        }
    }
    

    public function delete($id)
    {
        
        if($this->db->update('tb_tunggakan', array('is_hapus' => 1), array('id'=>$id))){
            return true;
        }else{
            return false;
        }
    }
}