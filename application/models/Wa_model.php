<?php
Class Wa_model extends CI_Model{
	
	public $number_key = 'eBki5ua379TKv7Xl';
	public $wa_api = "X2Y7UZOZT0WVQVTG";
	
    public function validasi($id, $status){
		$pembayaran = $this->db->where('id',$id)->get('tb_pembayaran')->row();
		$siswa = $this->db->where('no_induk',$pembayaran->nama_santri)->get('ref_siswa')->row();
		$atas_nama = $pembayaran->atas_nama;
		$jumlah = number_format($pembayaran->jumlah,0,",",".");
		$no_wa = $pembayaran->no_wa;
		if($status == 1){
		//jika status pembayaran valid
		$message = '
*Pesan ini otomatis dikirim dari sistem manajemen  laporan pembayaran*

Yth. (Bp/Ibu) ' . $atas_nama . ', Alhamdulillah melalui petugas kami Bp. Rizqi, bulan  ini kami telah menerima : 

';
$jenis = $this->db->get('ref_jenis_pembayaran')->result();
$list_jenis = array();
foreach($jenis as $row){
	$list_jenis[$row->id] = $row->jenis;
}
$detail = $query = $this->db->where('id_pembayaran',$id)->get('tb_detail_pembayaran')->result();
foreach($detail as $row){
	$message .= '• ' . $list_jenis[$row->id_jenis_pembayaran] .' sebesar Rp. ' . number_format($row->nominal,0,',','.') . ' 
';

}
$message .= '
Kami mengucapkan banyak terima kasih (Bp/Ibu) ' . $atas_nama . ' (Wali santri ' . $siswa->nama . ' Kelas ' . $siswa->kode .'), Yang senantiasa istiqomah menyisihkan sebagian hartanya untuk kewajiban pembayaran bulanan di PPATQ RF. 

Semoga pekerjaan dan usahanya diberi kelancaran dan keberkahan menghasilkan Rizqi yang banyak dan berkah, aamiin. Notifikasi ini bertujuan untuk menjaga amanah Bp/Ibu kepada kami. Bila ada yang perlu diklarifikasi mohon bisa menghubungi kami via WA atau telepon kami di nomor +62877-6757-2025.

Dan apabila ada keluhan / masuk / saran, dapat disalurkan melalui link berikut
(saran.ppatq-rf.id)
					';
		}elseif($status == 2){
			//jika status pembayaran tidak valid
			$message = '
*Pesan ini otomatis dikirim dari sistem*
Yth. (Bp/Ibu) ' . $atas_nama . ', Berdasarkan dari laporan pembayaran yang telah dikirimkan dengan rincian sbg berikut : 

';
$jenis = $this->db->get('ref_jenis_pembayaran')->result();
$list_jenis = array();
foreach($jenis as $row){
	$list_jenis[$row->id] = $row->jenis;
}
$detail = $query = $this->db->where('id_pembayaran',$id)->get('tb_detail_pembayaran')->result();
foreach($detail as $row){
	$message .= '• ' . $list_jenis[$row->id_jenis_pembayaran] .' sebesar Rp. ' . number_format($row->nominal,0,',','.') . ' 
';

}
$message .= '
mohon diulang kembali';
		}elseif($status == 0){
			//jika lapor pembayaran 
			$message = '
*Pesan ini otomatis dikirim dari sistem*
Terima kasih Bp/Ibu ' . $atas_nama . ', telah melaporkan  pembayaran sebesar Rp. ' . $jumlah . '

dengan rincian sbb :
';
$jenis = $this->db->get('ref_jenis_pembayaran')->result();
$list_jenis = array();
foreach($jenis as $row){
	$list_jenis[$row->id] = $row->jenis;
}
$detail = $query = $this->db->where('id_pembayaran',$id)->get('tb_detail_pembayaran')->result();
foreach($detail as $row){
	$message .= '• ' . $list_jenis[$row->id_jenis_pembayaran] .' sebesar Rp. ' . number_format($row->nominal,0,',','.') . ' 
';

}
$message .= '
Kami mengucapkan banyak terima kasih (Bp/Ibu) ' . $atas_nama . ' Yang telah melaporkan kepada kami.
Tunggu beberapa waktu, karena kami akan melakukan pencatan.
Kami akan memberikan informasi apabila pembayaran tsb diatas sesuai.


Semoga pekerjaan dan usahanya diberi kelancaran dan keberkahan menghasilkan Rizqi yang banyak dan berkah, aamiin. Notifikasi ini bertujuan untuk menjaga amanah Bp/Ibu kepada kami. Bila ada yang perlu diklarifikasi mohon bisa menghubungi kami via WA atau telepon kami di nomor ini.
					';
		}
		
                    
                       /*  echo "berhasil";
                        echo $this->db->last_query(); */
						$curl = curl_init();
						
						$dataSending = array();
						$dataSending["api_key"] = $this->wa_api;
						$dataSending["number_key"] = $this->number_key;
						$dataSending["phone_no"] = $no_wa;
						$dataSending["message"] = $message;
						$dataSending["wait_until_send"] = "1"; //This is an optional parameter, if you use this parameter the response will appear after sending the message is complete
						
						curl_setopt_array($curl, array(
						  CURLOPT_URL => 'https://api.watzap.id/v1/send_message',
						  CURLOPT_RETURNTRANSFER => true,
						  CURLOPT_ENCODING => '',
						  CURLOPT_MAXREDIRS => 10,
						  CURLOPT_TIMEOUT => 0,
						  CURLOPT_FOLLOWLOCATION => true,
						  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						  CURLOPT_CUSTOMREQUEST => 'POST',
						  CURLOPT_POSTFIELDS => json_encode($dataSending),
						  CURLOPT_HTTPHEADER => array(
							'Content-Type: application/json'
						  ),
						));

						$response = curl_exec($curl);
						
						curl_close($curl);
						
						
						$convert_res = json_decode($response);
						$status = 0;
						if($convert_res->status == 200){
							$status = 1;
						}
						$data = array(
							'id_pembayaran' => $id,
							'nama' => $siswa->nama,
							'no_wa' => $pembayaran->no_wa,
							'pesan' => $message,
							'status' => $status,
						);
						$hasil = $this->db->insert('tb_send_wa',$data);
						

						return $response;
	}

	public function validasi_admin($id, $status){
		$bulan = array(1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
		$pembayaran = $this->db->where('id',$id)->get('tb_pembayaran')->row();
		$siswa = $this->db->where('no_induk',$pembayaran->nama_santri)->get('santri_detail')->row();
		$bank = $this->db->where('id',$pembayaran->bank_pengirim)->get('ref_bank')->row();
		$id_santri = $pembayaran->nama_santri;
		$atas_nama = $pembayaran->atas_nama;
		$jumlah = number_format($pembayaran->jumlah,0,",",".");
		$no_wa = $pembayaran->no_wa;
		$tipe = $pembayaran->tipe;
		$nama_ayah = $siswa->nama_lengkap_ayah ?? '';
		$nama_ibu = $siswa->nama_lengkap_ibu ?? '';
		if($status == 1){
			if($tipe == "Bank"){
$message = '
[ Admin Bendahara PPATQRF- Transfer ]

Yth. Bp/Ibu ' . $nama_ayah . '/' . $nama_ibu . ', Wali Santri ' . $siswa->nama . ' kelas ' . $siswa->kelas . ', kami telah menginputkan data pembayaran melalui sistem manajemen keuangan sesuai Kwitansi yang terbayarkan secara *transfer* untuk bulan ' . $bulan[$pembayaran->periode] . ' sebesar Rp. ' . number_format($pembayaran->jumlah,0,',','.') . ' pada tanggal ' . date('d-m-Y', strtotime($pembayaran->tanggal_bayar)) . ' melalui Bank ' . $bank->nama . ' atas nama ' . $atas_nama . '	
dengan rincian sbb : 

';
$jenis = $this->db->get('ref_jenis_pembayaran')->result();
$list_jenis = array();
foreach($jenis as $row){
	$list_jenis[$row->id] = $row->jenis;
}
$detail = $query = $this->db->where('id_pembayaran',$id)->get('tb_detail_pembayaran')->result();
foreach($detail as $row){
	$message .= '• ' . $list_jenis[$row->id_jenis_pembayaran] .' sebesar Rp. ' . number_format($row->nominal,0,',','.') . ' 
';

}
$message .= '
Bila ada yang perlu diklarifikasi dapat menghubungi  WA di nomor +62877-6757-2025. 
untuk penyampaian masukan melalui https://saran.ppatq-rf.id
Kami ucapkan banyak terima kasih kepada (Bp/Ibu) ' . $nama_ayah . '/' . $nama_ibu . ', salam kami kepada keluarga.
Semoga pekerjaan dan usahanya diberikan kelancaran dan menghasilkan Rizqi yang banyak dan berkah, aamiin.
';
$message .= '
--Riwayat pelaporan--- 
';
	$bulan = (int)date('m');
	$tanggal = [];
	$jumlah = [];
	for($i=($bulan-1); $i>=$bulan-5; $i--){
		$new_bulan = $i;
		if($i <= 0 ){
			$new_bulan = (12 + $i);
		}
		$tahun = date('Y');
		$rpembayaran = $this->db->where('MONTH(tanggal_bayar)',$new_bulan)->where('YEAR(tanggal_bayar)',$tahun)->where('validasi',1)->where('nama_santri',$id_santri)->get('tb_pembayaran')->result();
		
		foreach($rpembayaran as $row){
			$message .= '*' . $bulan[$new_bulan] .'* ';
			$message .= $row->tanggal_bayar .' : Rp. ' . number_format($row->jumlah,0,',','.') . '
';
		}
	}
$message .= '
--Cek Kevalidan Bio Data Santri---
NIK : ' . $siswa->nik . '
Tanggal Lahir  : ' . date('d-m-Y',strtotime($siswa->tanggal_lahir)). '
Alamat : ' . $siswa->alamat . '
';

$message .= '
JIka tidak sesuai, silakan *#balas-reply* dengan menyertakan data yang benar di WA ini.
Kami akan update sesuai yang disampaikan
				';
			}else{
$message = '
[ Admin Bendahara PPATQRF- Tunai ]

Yth. Bp/Ibu ' . $nama_ayah . '/' . $nama_ibu . ', Wali Santri ' . $siswa->nama . ' kelas ' . $siswa->kelas . ', kami telah menginputkan data pembayaran melalui sistem manajemen keuangan sesuai Kwitansi yang terbayarkan secara *tunai/cash* untuk bulan ' . $bulan[$pembayaran->periode] . ' sebesar Rp. ' . number_format($pembayaran->jumlah,0,',','.') . ' pada tanggal ' . date('d-m-Y', strtotime($pembayaran->tanggal_bayar)) . ' melalui Bank ' . $bank->nama . ' atas nama ' . $atas_nama . '	
dengan rincian sbb : 

';
$jenis = $this->db->get('ref_jenis_pembayaran')->result();
$list_jenis = array();
foreach($jenis as $row){
	$list_jenis[$row->id] = $row->jenis;
}
$detail = $query = $this->db->where('id_pembayaran',$id)->get('tb_detail_pembayaran')->result();
foreach($detail as $row){
	$message .= '• ' . $list_jenis[$row->id_jenis_pembayaran] .' sebesar Rp. ' . number_format($row->nominal,0,',','.') . ' 
';

}
$message .= '
Bila ada yang perlu diklarifikasi dapat menghubungi  WA di nomor +62877-6757-2025. 
untuk penyampaian masukan melalui https://saran.ppatq-rf.id
Kami ucapkan banyak terima kasih kepada (Bp/Ibu) ' . $nama_ayah . '/' . $nama_ibu . ', salam kami kepada keluarga.
Semoga pekerjaan dan usahanya diberikan kelancaran dan menghasilkan Rizqi yang banyak dan berkah, aamiin.
';
$message .= '
--Riwayat pelaporan--- 
';
	$bulan = (int)date('m');
	$tanggal = [];
	$jumlah = [];
	for($i=($bulan-1); $i>=$bulan-5; $i--){
		$new_bulan = $i;
		if($i <= 0 ){
			$new_bulan = (12 + $i);
		}
		$tahun = date('Y');
		$rpembayaran = $this->db->where('MONTH(tanggal_bayar)',$new_bulan)->where('YEAR(tanggal_bayar)',$tahun)->where('validasi',1)->where('nama_santri',$id_santri)->get('tb_pembayaran')->result();
		
		foreach($rpembayaran as $row){
			$message .= '*' . $bulan[$new_bulan] .'* ';
			$message .= $row->tanggal_bayar .' : Rp. ' . number_format($row->jumlah,0,',','.') . '
';
		}
	}
$message .= '
--Cek Kevalidan Bio Data Santri---
NIK : ' . $siswa->nik . '
Tanggal Lahir  : ' . date('d-m-Y',$siswa->tanggal_lahir). '
Alamat : ' . $siswa->alamat . '
';

$message .= '
JIka tidak sesuai, silakan *#balas-reply* dengan menyertakan data yang benar di WA ini.
Kami akan update sesuai yang disampaikan
';
			}
		}elseif($status == 2){
			//jika status pembayaran tidak valid
			$message = '
*Pesan ini otomatis dikirim dari sistem*
Yth. (Bp/Ibu) ' . $atas_nama . ', Berdasarkan dari laporan pembayaran yang telah dikirimkan dengan rincian sbg berikut : 

';
$jenis = $this->db->get('ref_jenis_pembayaran')->result();
$list_jenis = array();
foreach($jenis as $row){
	$list_jenis[$row->id] = $row->jenis;
}
$detail = $query = $this->db->where('id_pembayaran',$id)->get('tb_detail_pembayaran')->result();
foreach($detail as $row){
	$message .= '• ' . $list_jenis[$row->id_jenis_pembayaran] .' sebesar Rp. ' . number_format($row->nominal,0,',','.') . ' 
';

}
$message .= '
mohon diulang kembali';
		}elseif($status == 0){
			//jika lapor pembayaran 
			$message = '
*Pesan ini otomatis dikirim dari sistem*
Terima kasih Bp/Ibu ' . $atas_nama . ', telah melaporkan  pembayaran sebesar Rp. ' . $jumlah . '

dengan rincian sbb :
';
$jenis = $this->db->get('ref_jenis_pembayaran')->result();
$list_jenis = array();
foreach($jenis as $row){
	$list_jenis[$row->id] = $row->jenis;
}
$detail = $query = $this->db->where('id_pembayaran',$id)->get('tb_detail_pembayaran')->result();
foreach($detail as $row){
	$message .= '• ' . $list_jenis[$row->id_jenis_pembayaran] .' sebesar Rp. ' . number_format($row->nominal,0,',','.') . ' 
';

}
$message .= '
Kami mengucapkan banyak terima kasih (Bp/Ibu) ' . $atas_nama . ' Yang telah melaporkan kepada kami.
Tunggu beberapa waktu, karena kami akan melakukan pencatan.
Kami akan memberikan informasi apabila pembayaran tsb diatas sesuai.


Semoga pekerjaan dan usahanya diberi kelancaran dan keberkahan menghasilkan Rizqi yang banyak dan berkah, aamiin. Notifikasi ini bertujuan untuk menjaga amanah Bp/Ibu kepada kami. Bila ada yang perlu diklarifikasi mohon bisa menghubungi kami via WA atau telepon kami di nomor ini.
					';
		}
		
                    
                       /*  echo "berhasil";
                        echo $this->db->last_query(); */
						$curl = curl_init();
						
						$dataSending = array();
						$dataSending["api_key"] = $this->wa_api;
						$dataSending["number_key"] = $this->number_key;
						$dataSending["phone_no"] = $no_wa;
						$dataSending["message"] = $message;
						$dataSending["wait_until_send"] = "1"; //This is an optional parameter, if you use this parameter the response will appear after sending the message is complete
						
						curl_setopt_array($curl, array(
						  CURLOPT_URL => 'https://api.watzap.id/v1/send_message',
						  CURLOPT_RETURNTRANSFER => true,
						  CURLOPT_ENCODING => '',
						  CURLOPT_MAXREDIRS => 10,
						  CURLOPT_TIMEOUT => 0,
						  CURLOPT_FOLLOWLOCATION => true,
						  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						  CURLOPT_CUSTOMREQUEST => 'POST',
						  CURLOPT_POSTFIELDS => json_encode($dataSending),
						  CURLOPT_HTTPHEADER => array(
							'Content-Type: application/json'
						  ),
						));

						$response = curl_exec($curl);
						
						curl_close($curl);
						
						
						$convert_res = json_decode($response);
						$status = 0;
						if($convert_res->status == 200){
							$status = 1;
						}
						$data = array(
							'id_pembayaran' => $id,
							'nama' => $siswa->nama,
							'no_wa' => $pembayaran->no_wa,
							'pesan' => $message,
							'status' => $status,
						);
						$hasil = $this->db->insert('tb_send_wa',$data);
						

						return $response;
	}

	public function get_all()
    {
            $query = $this->db->join('tb_pembayaran','tb_pembayaran.id=tb_send_wa.id_pembayaran')->order_by('tb_send_wa.id','desc')->get('tb_send_wa');
            return $query->result();
    }
	public function get_not_send(){
		$query = $this->db->where('status',0)->get('tb_send_wa');
		return $query->result();
	}
	public function get_send(){
		$query = $this->db->where('status',1)->get('tb_send_wa');
		return $query->result();
	}
    public function get_by_id($id)
    {
            $query = $this->db->where('id',$id)->get('tb_send_wa');
            return $query->row();
    }
    
    public function insert(){
        $data = array(
			'nama' => $this->input->post('nama'),	
			'no_wa' => $this->input->post('no_wa'),	
			'pesan' => $this->input->post('pesan'),	
		);
        if($this->db->insert('tb_send_wa',$data)){
            return true;
        }else{
            return false;
        }
        
    }
    public function insert_kelas($data){
        
        if($this->db->insert('tb_send_wa',$data)){
            return true;
        }else{
            return false;
        }
        
    }

    public function update(){
        $data = array(
			'nama' => $this->input->post('nama'),	
			'no_wa' => $this->input->post('no_wa'),	
			'pesan' => $this->input->post('pesan'),	
		);

        if($this->db->update('tb_send_wa', $data, array('id' => $this->input->post('id')))){
            return true;
        }else{
            return false;
        }
    }
	public function update_status($status,$id){
		$data = array(
			'status' => $status,	
		);

        if($this->db->update('tb_send_wa', $data, array('id' => $id))){
            return true;
        }else{
            return false;
        }
	}

    public function delete($id)
    {
        if($this->db->delete('tb_send_wa', array('id' => $id))){
            return true;
        }else{
            return false;
        }
    }
	public function send_wa($data){
		
		$curl = curl_init();
		
		$dataSending = array();
		$dataSending["api_key"] = $this->wa_api;
		$dataSending["number_key"] = $this->number_key;
		$dataSending["phone_no"] = $data['no_wa'];
		$dataSending["message"] = $data['pesan'];
		$dataSending["wait_until_send"] = "1"; //This is an optional parameter, if you use this parameter the response will appear after sending the message is complete

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://api.watzap.id/v1/send_message',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => json_encode($dataSending),
			CURLOPT_HTTPHEADER => array(
			'Content-Type: application/json'
			),
		));

		$response = curl_exec($curl);
		
		curl_close($curl);
		return $response;
	}
	public function send_wa_img($data){
		
		$curl = curl_init();
		
		$dataSending = array();
		$dataSending["api_key"] = $this->wa_api;
		$dataSending["number_key"] = $this->number_key;
		$dataSending["phone_no"] = $data['no_wa'];
		$dataSending["message"] = $data['pesan'];
		$dataSending["url"] = $data['url'];
		$dataSending["wait_until_send"] = "1"; //This is an optional parameter, if you use this parameter the response will appear after sending the message is complete
		
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://api.watzap.id/v1/send_image_url',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => json_encode($dataSending),
			CURLOPT_HTTPHEADER => array(
			'Content-Type: application/json'
			),
		));

		$response = curl_exec($curl);
		
		curl_close($curl);
		return $response;
	}
	public function send_wa_file($data){
		
		$curl = curl_init();
		
		$dataSending = array();
		$dataSending["api_key"] = $this->wa_api;
		$dataSending["number_key"] = $this->number_key;
		$dataSending["phone_no"] = $data['no_wa'];
		$dataSending["url"] = $data['url'];
		$dataSending["wait_until_send"] = "1"; //This is an optional parameter, if you use this parameter the response will appear after sending the message is complete
		
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://api.watzap.id/v1/send_file_url',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => json_encode($dataSending),
			CURLOPT_HTTPHEADER => array(
			'Content-Type: application/json'
			),
		));

		$response = curl_exec($curl);
		
		curl_close($curl);
		return $response;
	}
}

