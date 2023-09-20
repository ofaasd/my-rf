<?php
Class Pembayaran_model extends CI_Model{
    public $nama;

    public function get_all()
    {
            $query = $this->db->where("is_hapus",0)->get('tb_pembayaran');
            return $query->result();
    }

    public function get_by_id($id)
    {
        $query = $this->db->where('id',$id)->get('tb_pembayaran');
        return $query->row();
    }
    public function get_by_periode($periode,$tahun){
		$where = array();
		if($periode == 0){
			$where = array(
				'tahun'=>$tahun,
				'is_hapus'=>0
			);
		}else{
			$where = array(
				'periode'=>$periode,
				'tahun'=>$tahun,
				'is_hapus'=>0
			);
		}
        $query = $this->db->order_by("id desc")->where($where)->get('tb_pembayaran');
        return $query->result();
    }
	public function get_by_santri($nama_santri){
		$query = $this->db->where(['nama_santri'=>$nama_santri,'is_hapus'=>0])->get('tb_pembayaran');
        return $query->result();
	}
	public function get_by_santri_periode($nama_santri, $periode){
		$query = $this->db->where(['nama_santri'=>$nama_santri,'is_hapus'=>0,'periode'=>$periode])->get('tb_pembayaran');
        return $query->result();
	}
    
    public function insert(){
        $jumlah = str_replace(".", "", $this->input->post('jumlah'));
        $data = array(
            'nama_santri' => $this->input->post('nama_santri'),
            'jumlah' => $jumlah,
            'tanggal_bayar' => $this->input->post('tanggal_bayar'),
            'periode' => $this->input->post('periode'),
            'tahun' => $this->input->post('tahun'),
            'bank_pengirim' => $this->input->post('bank_pengirim'),
            'atas_nama' => $this->input->post('atas_nama'),
            'catatan' => $this->input->post('catatan'),
            'no_wa' => $this->input->post('no_wa'),
            'created_at' => date('Y-m-d H:i:s'),
			'input_by' => 1,
        );
		$data2 = array(
			'nama_santri' => $this->input->post('nama_santri'),
            'jumlah' => $jumlah,
            'tanggal_bayar' => $this->input->post('tanggal_bayar'),
            'periode' => $this->input->post('periode'),
            'tahun' => $this->input->post('tahun'),
            'bank_pengirim' => $this->input->post('bank_pengirim'),
            'atas_nama' => $this->input->post('atas_nama'),
            'no_wa' => $this->input->post('no_wa'),
			'is_hapus' => 0,
		);
		$cek = $this->db->where($data2)->get("tb_pembayaran")->num_rows();
		if($cek > 0){
			return 2; //Data suda pernah dimasukan
		}else{
			$query = $this->db->insert('tb_pembayaran',$data);
			if($query){
				$id = $this->db->insert_id();
				$jenis_pembayaran = $this->input->post('jenis_pembayaran');
				$id_jenis_pembayaran = $this->input->post('id_jenis_pembayaran');
				//var_dump($id_jenis_pembayaran);
				//exit;
				foreach($jenis_pembayaran as $key=>$value){
					if($value != 0 && !empty($value)){
						$nominal = str_replace(".", "", $value);
						$data_detail = array(
							'id_pembayaran'=>$id,
							'id_jenis_pembayaran' => $this->input->post('id_jenis_pembayaran')[$key],
							'nominal' => $nominal, 
						);
						$query = $this->db->insert('tb_detail_pembayaran',$data_detail);
					}
				}
				return 1; //data berhasil dimasukan
			}else{
				return 0; //data gagal dimasukan
			}
		}
        
    }
    public function insert_admin(){
        $jumlah = str_replace(".", "", $this->input->post('jumlah'));
        $tipe = $this->input->post('tipe');
        $bank_pengirim = 0;
        if($tipe == "Bank")
            $bank_pengirim = $this->input->post('bank_pengirim');
            
        $data = array(
            'nama_santri' => $this->input->post('nama_santri'),
            'jumlah' => $jumlah,
            'tanggal_bayar' => $this->input->post('tanggal_bayar'),
            'periode' => $this->input->post('periode'),
            'tahun' => $this->input->post('tahun'),
            'bank_pengirim' => $bank_pengirim,
            'atas_nama' => $this->input->post('atas_nama'),
            'catatan' => $this->input->post('catatan'),
            'no_wa' => $this->input->post('no_wa'),
            'validasi' => $this->input->post('validasi'),
            'note_validasi' => $this->input->post('note_validasi'),
            'created_at' => date('Y-m-d H:i:s'),
            'tipe' => $tipe,
			'input_by' => 2,
        );
        $query = $this->db->insert('tb_pembayaran',$data);
        if($query){
            $id = $this->db->insert_id();
            $jenis_pembayaran = $this->input->post('jenis_pembayaran');
            $id_jenis_pembayaran = $this->input->post('id_jenis_pembayaran');
            //var_dump($id_jenis_pembayaran);
            //exit;
            foreach($jenis_pembayaran as $key=>$value){
                if($value != 0 && !empty($value)){
                    $nominal = str_replace(".", "", $value);
                    $data_detail = array(
                        'id_pembayaran'=>$id,
                        'id_jenis_pembayaran' => $this->input->post('id_jenis_pembayaran')[$key],
                        'nominal' => $nominal, 
                    );
                    $query = $this->db->insert('tb_detail_pembayaran',$data_detail);
                }
            }
            return true;
        }else{
            return false;
        }
        
    }
    public function update_admin(){
        $id = $this->input->post('id');
        $jumlah = str_replace(".", "", $this->input->post('jumlah'));
        $tipe = $this->input->post('tipe');
        $bank_pengirim = 0;
        if($tipe == "Bank")
            $bank_pengirim = $this->input->post('bank_pengirim');

        $data = array(
            'nama_santri' => $this->input->post('nama_santri'),
            'jumlah' => $jumlah,
            'tanggal_bayar' => $this->input->post('tanggal_bayar'),
            'periode' => $this->input->post('periode'),
            'tahun' => $this->input->post('tahun'),
            'bank_pengirim' => $bank_pengirim,
            'atas_nama' => $this->input->post('atas_nama'),
            'catatan' => $this->input->post('catatan'),
            'no_wa' => $this->input->post('no_wa'),
            'validasi' => $this->input->post('validasi'),
			'note_validasi' => $this->input->post('note_validasi'),
            'created_at' => date('Y-m-d H:i:s'),
            'tipe' => $tipe,
        );
        $query = $this->db->update('tb_pembayaran',$data,array('id'=>$id));
        $this->db->delete('tb_detail_pembayaran', array('id_pembayaran' => $id));
        if($query){
            //$id = $this->db->insert_id();
            $jenis_pembayaran = $this->input->post('jenis_pembayaran');
            $id_jenis_pembayaran = $this->input->post('id_jenis_pembayaran');
            //var_dump($id_jenis_pembayaran);
            //exit;
            foreach($jenis_pembayaran as $key=>$value){
                if($value != 0 && !empty($value)){
                    $nominal = str_replace(".", "", $value);
                    $data_detail = array(
                        'id_pembayaran'=>$id,
                        'id_jenis_pembayaran' => $this->input->post('id_jenis_pembayaran')[$key],
                        'nominal' => $nominal, 
                    );
                    $query = $this->db->insert('tb_detail_pembayaran',$data_detail);
                }
            }
            return true;
        }else{
            return false;
        }
        
    }

    public function update(){
        $this->nama = $_POST['nama'];

        if($this->db->update('tb_pembayaran', $this, array('id' => $_POST['id']))){
            return true;
        }else{
            return false;
        }
    }
    public function update_validasi($id){
        
        $validasi = $this->get_by_id($id)->validasi;
        $data = array();

        if($validasi == 0){
            $data = array(
                'validasi' => 1,
            );
        }else{
            $data = array(
                'validasi' => 0,
            );
        }

        if($this->db->update('tb_pembayaran', $data, array('id' => $id))){
            return true;
        }else{
            return false;
        }
    }
	public function invalid($id){
        
        $validasi = $this->get_by_id($id)->validasi;
        $data = array();

        $data = array(
			'validasi' => 2,
		);

        if($this->db->update('tb_pembayaran', $data, array('id' => $id))){
            return true;
        }else{
            return false;
        }
    }
	public function valid($id){
        
        $validasi = $this->get_by_id($id)->validasi;
        $data = array();

        $data = array(
			'validasi' => 1,
		);

        if($this->db->update('tb_pembayaran', $data, array('id' => $id))){
            return true;
        }else{
            return false;
        }
    }
	public function cancel($id){
        
        $validasi = $this->get_by_id($id)->validasi;
        $data = array();

        $data = array(
			'validasi' => 0,
		);

        if($this->db->update('tb_pembayaran', $data, array('id' => $id))){
            return true;
        }else{
            return false;
        }
    }
	public function new_validasi($id,$status){
        
        $validasi = $this->get_by_id($id)->validasi;
        $data = array();

        
		if($status == 1){
			$data = array(
				'validasi' => $status,
				'tanggal_validasi' => date('Y-m-d'),
			);
		}else{
			$data = array(
				'validasi' => $status,
				
			);
		}

        if($this->db->update('tb_pembayaran', $data, array('id' => $id))){
            return true;
        }else{
            return false;
        }
    }

    public function delete($id)
    {
        
        if($this->db->update('tb_pembayaran', array('is_hapus' => 1), array('id'=>$id))){
            return true;
        }else{
            return false;
        }
    }
	public function insert_json($json){

        //$this->db->truncate('ref_siswa');

        $hasil = 0;
        foreach($json as $row){
			$nama_santri = $row->id;
			$jumlah = 0;
			$detail = array();
			if(!empty($row->spp) ){
				$detail[1] = (int) str_replace(",","",str_replace("Rp","",$row->spp));
				$jumlah += $detail[1];
			}else $detail[1] = 0;
			
			if(!empty($row->ziarah) ){
				$detail[16] = (int) str_replace(",","",str_replace("Rp","",$row->ziarah));
				$jumlah += $detail[16];
			}else $detail[16] = 0;
			
			if(!empty($row->uangsaku) ){
				$detail[3] = (int) str_replace(",","",str_replace("Rp","",$row->uangsaku));
				$jumlah += $detail[3];
			}else $detail[3] = 0;
			
			if(!empty($row->infaq) ){
				$detail[4] = (int) str_replace(",","",str_replace("Rp","",$row->infaq));
				$jumlah += $detail[4];
			}else $detail[4] = 0;
			
			if(!empty($row->pelunasan) ){
				$detail[12] = (int) str_replace(",","",str_replace("Rp","",$row->pelunasan));
				$jumlah += $detail[12];
			}else $detail[12] = 0;
			
			if(!empty($row->saku) ){
				$detail[15] = (int) str_replace(",","",str_replace("Rp","",$row->saku));
				$jumlah += $detail[15];
			}else $detail[15] = 0;
			
			if(!empty($row->lain) ){
				$detail[6] = (int) str_replace(",","",str_replace("Rp","",$row->lain));
				$jumlah += $detail[6];
			}else $detail[6] = 0;
			
            $data = array(
                'nama_santri' => $row->id,
                'jumlah' => $jumlah,
				'tanggal_bayar' => date('Y-m-d'),
				'bank_pengirim' => 0,
				'atas_nama' => 'RF',
				'catatan' => 'Terverifikasi RF',
				'no_wa' => 0,
				'periode' => 1,
				'tahun' => 2023,
				'validasi' => 1,
				'tipe' => 'Cash',
				'created_at' => date('Y-m-d'),
				'updated_at' => date('Y-m-d'),
            );
            if($this->db->insert('tb_pembayaran',$data)){
                $id = $this->db->insert_id();
				$nominal = 0;
				foreach($detail as $key=>$value){
					if($value != 0){
						$data_detail = array(
							'id_pembayaran' => $id,
							'id_jenis_pembayaran' => $key,
							'nominal' => $value,
						);
                        $nominal += $value;
						$this->db->insert('tb_detail_pembayaran',$data_detail);
					}
				}
				$hasil++;
            }
            $data = array(
                'jumlah' => $nominal,
            );
            $this->db->update('tb_pembayaran',$data,array('id',$id));
        }
        if($hasil > 0){
            return true;
        }else{
            return false;
        }
    }
    public function verifikasi_jumlah(){
        $jumlah = str_replace(".", "", $this->input->post('jumlah'));
        $jumlah = (int)$jumlah;
        $jenis_pembayaran = $this->input->post('jenis_pembayaran');
        $jumlah2 = 0;
        foreach($jenis_pembayaran as $key=>$value){
            if($value != 0 && !empty($value)){
                $nominal = str_replace(".", "", $value);
                $jumlah2 += (int)$nominal;
            }
        }
        return ($jumlah == $jumlah2);
    }
}
