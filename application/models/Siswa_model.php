<?php
Class Siswa_model extends CI_Model{
    public $nama;
    public $kode;
    public $kode_murroby;
	public $status;

    public function get_all()
    {
            $query = $this->db->where('deleted_at is NULL', NULL, FALSE)->get('ref_siswa');
            return $query->result();
    }
    public function get_all_detail()
    {
            $query = $this->db->where('deleted_at is NULL', NULL, FALSE)->where('status',0)->order_by('kelas','asc')->get('santri_detail');
            return $query->result();
    }
    public function get_all_order_kelas()
    {
            $query = $this->db->where('deleted_at is NULL', NULL, FALSE)->where('status',0)->order_by('kelas','asc')->get('santri_detail');
            return $query->result();
    }
    public function get_kelas_all()
    {
            $query = $this->db->where('deleted_at is NULL', NULL, FALSE)->select('kelas')->group_by('kelas')->order_by('kelas','asc')->get('santri_detail');
            return $query->result();
    }

    public function get_by_id($id)
    {
            $query = $this->db->where('deleted_at is NULL', NULL, FALSE)->where('id',$id)->get('ref_siswa');
            return $query->row();
    }
    public function get_by_ni($no_induk)
    {
            $query = $this->db->where('deleted_at is NULL', NULL, FALSE)->where('no_induk',$no_induk)->get('ref_siswa');
            return $query->row();
    }
    public function get_by_ni2($no_induk)
    {
            $query = $this->db->where('deleted_at is NULL', NULL, FALSE)->where('no_induk',$no_induk)->where('status',0)->get('santri_detail');
            return $query->row();
    }
    public function get_kode_1a(){
        $query = $this->db->where('deleted_at is NULL', NULL, FALSE)->where('kode','1a')->get('ref_siswa');
        return $query->num_rows();
    }
    public function get_kode_1b(){
        $query = $this->db->where('deleted_at is NULL', NULL, FALSE)->where('kode','1b')->get('ref_siswa');
        return $query->num_rows();
    }
    
    public function verifikasi_siswa(){
        $id_santri = $this->input->post('nama_santri');
        $kode = $this->input->post('kode');
        $query = $this->db->where('deleted_at is NULL', NULL, FALSE)->where(['no_induk'=>$id_santri,'kode'=>$kode])->get('ref_siswa');
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function insert(){
        $this->nama = $_POST['nama'];
        $this->kode = $_POST['kode'];
        $this->kode_murroby = $_POST['kode_murroby'];
        $this->status = $_POST['status'];
        if($this->db->insert('ref_siswa',$this)){
            return true;
        }else{
            return false;
        }
        
    }
    public function insert_json($json){

        $this->db->truncate('ref_siswa');

        $hasil = 0;
        foreach($json as $row){
            $data = array(
                'nama' => $row->nama,
                'kode' => $row->kelas,
				'kode_murroby' => $row->murroby,
            );
            if($this->db->insert('ref_siswa',$data)){
                $hasil ++;
            }
        }
        if($hasil > 0){
            return true;
        }else{
            return false;
        }
    }
	public function insert_json_detail($json){
        $kelas = $this->input->post('kelas');
        //$delete = $this->db->delete('santri_detail',array('kelas'=>$kelas));
		$hasil = 0;
        foreach($json as $row){
			if(!empty($row->no_induk) && !empty($row->nama)){
				$data = array(
					'no_induk' => $row->no_induk,
					'nama' => $row->nama,
					'nisn' => $row->nisn ?? '',
					'nik' => $row->nik ?? '',
					'anak_ke' => $row->anak_ke ?? '', 
					'tempat_lahir' => $row->tempat_lahir ?? '',
					'tanggal_lahir' => $row->tanggal_lahir ?? '',
					'usia' => $row->usia ?? '',
					'jenis_kelamin' => $row->jenis_kelamin ?? '',
					'alamat' => $row->alamat ?? '',
					'kelurahan' => $row->kelurahan ?? '',
					'kecamatan' => $row->kecamatan ?? '',
					'kabkota' => $row->kabkota ?? '',
					'provinsi' => $row->provinsi ?? '',
					'kode_pos' => $row->kode_pos ?? '',
					'nik_kk' => $row->nik_kk ?? '',
					'nama_lengkap_ayah' => $row->nama_lengkap_ayah ?? '',
					'pendidikan_ayah' => $row->pendidikan_ayah ?? '',
					'pekerjaan_ayah' => $row->pekerjaan_ayah ?? '',
					'nama_lengkap_ibu' => $row->nama_lengkap_ibu ?? '',
					'pendidikan_ibu' => $row->pendidikan_ibu ?? '',
					'pekerjaan_ibu' => $row->pekerjaan_ibu ?? '',
					'no_hp' => $row->no_hp ?? '',
					'kelas' => $this->input->post('kelas'),
				);
				if($this->db->insert('santri_detail',$data)){
					$hasil ++;
				}
				$data = array(
					'nama' => $row->nama ?? '',
					'kode' => $this->input->post('kelas'),
					'no_induk' => $row->no_induk ?? '',
					//'kode_murroby' => $row->murroby,
				);
				if($this->db->insert('ref_siswa',$data)){
					$hasil++;
				}
			}

           
        }
		//exit;
        if($hasil > 0){
            return true;
        }else{
            return false;
        }
	}
	public function update_siswa_detail(){
		$data = array(
			
			'nama' => $this->input->post('nama'),
			'nisn' => $this->input->post('nisn'),
			'nik' => $this->input->post('nik'),
			'anak_ke' => $this->input->post('anak_ke'),
			'tempat_lahir' => $this->input->post('tempat_lahir'),
			'tanggal_lahir' => $this->input->post('tanggal_lahir'),
			'usia' => $this->input->post('usia'),
			'jenis_kelamin' => $this->input->post('jenis_kelamin'),
			'alamat' => $this->input->post('alamat'),
			'kelurahan' => $this->input->post('kelurahan'),
			'kecamatan' => $this->input->post('kecamatan'),
			'kabkota' => $this->input->post('kabkota'),
			'provinsi' => $this->input->post('provinsi'),
			'kode_pos' => $this->input->post('kode_pos'),
			'nik_kk' => $this->input->post('nik_kk'),
			'nama_lengkap_ayah' => $this->input->post('nama_lengkap_ayah'),
			'pendidikan_ayah' => $this->input->post('pendidikan_ayah'),
			'pekerjaan_ayah' => $this->input->post('pekerjaan_ayah'),
			'nama_lengkap_ibu' => $this->input->post('nama_lengkap_ibu'),
			'pendidikan_ibu' => $this->input->post('pendidikan_ibu'),
			'pekerjaan_ibu' => $this->input->post('pekerjaan_ibu'),
			'no_hp' => $this->input->post('no_hp'),
			//'kelas' => $this->input->post('kelas'),
		);
		$update = $this->db->update('santri_detail',$data,array('no_induk' => $this->input->post('no_induk')));
		if($update){
			$data2 = array(
				'nama' => $this->input->post('nama'),
			);
			$update = $this->db->update('ref_siswa',$data2,array('no_induk' => $this->input->post('no_induk')));
			return true;
		}else{
			return false;
		}
	}

    public function update(){
        $this->nama = $_POST['nama'];
        $this->kode = $_POST['kode'];
		$this->kode_murroby = $_POST['kode_murroby'];
		$this->status = $_POST['status'];

        if($this->db->update('ref_siswa', $this, array('id' => $_POST['id']))){
            return true;
        }else{
            return false;
        }
    }

    public function delete($id)
    {
        if($this->db->delete('ref_siswa', array('id' => $id))){
            return true;
        }else{
            return false;
        }
    }

    public function list_siswa_ni(){
        $siswa = $this->get_all();
        $list = array();
        foreach($siswa as $row){
            $list[$row->no_induk] = $row->nama;
        }
        return $list;
    }
	
}
