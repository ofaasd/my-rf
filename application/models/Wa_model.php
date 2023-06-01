<?php
Class Wa_model extends CI_Model{
	
	public $number_key = '2Z17zDLogBMOaxnc';
	public $wa_api = "X2Y7UZOZT0WVQVTG";
	
    public function validasi($id, $status){
		$pembayaran = $this->db->where('id',$id)->get('tb_pembayaran')->row();
		$atas_nama = $pembayaran->atas_nama;
		$jumlah = number_format($pembayaran->jumlah,0,",",".");
		$no_wa = $pembayaran->no_wa;
		if($status == 1){
		//jika status pembayaran valid
		$message = '
*Pesan ini otomatis dikirim dari sistem*
Yth. (Bp/Ibu) ' . $atas_nama . ', Alhamdulillah melalui petugas kami Bp. Muhadi, bulan  ini kami telah menerima : 

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
Kami mengucapkan banyak terima kasih (Bp/Ibu) ' . $atas_nama . '  Yang tetap istiqomah menyisihkan sebagian hartanya untuk kewajiban pembayaran bulanan di PPATQ RF. 

Semoga pekerjaan dan usahanya diberi kelancaran dan keberkahan menghasilkan Rizqi yang banyak dan berkah, aamiin. Notifikasi ini bertujuan untuk menjaga amanah Bp/Ibu kepada kami. Bila ada yang perlu diklarifikasi mohon bisa menghubungi kami via WA atau telepon kami di nomor ini.
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
						
						$siswa = $this->db->where('id',$pembayaran->nama_santri)->get('ref_siswa')->row();
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
}

