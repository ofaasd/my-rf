<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran extends CI_Controller {
    
    public function __construct(){
        parent::__construct();

        $this->load->model('Jenis_model','jenis');
        $this->load->model('Bank_model','bank');
        $this->load->model('Pembayaran_model','pembayaran');
        $this->load->model('Detail_pembayaran_model','detail_pembayaran');
		$this->load->model('Detail_pembayaran_model','detail');
		$this->load->model('Tunggakan_model','tunggakan');
		$this->load->model('Pembayaran_tunggakan_model','b_tunggakan');
		
        $this->load->model('Siswa_model','siswa');

    }
	public $bulan = array(1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');

	public function index()
	{
		if(!empty($this->session->userdata('siswa_id'))){
			redirect(base_url('index.php/pembayaran/detail_pembayaran'));
		}
        $data['bukatutup'] = $this->db->order_by('id','desc')->limit(1)->get("tb_bukatutup")->row();
		$data['jenis_pembayaran'] = $this->jenis->get_all();
		$data['bank_pengirim'] = $this->bank->get_all();
        $data['siswa'] = $this->siswa->get_all();
        $data['kode'] = $this->siswa->get_kelas_all();
		$data['bulan'] = $this->bulan;
		$var['title'] = 'PPATQ Roudlotul Falah';
		$var['content'] = $this->load->view('pembayaran/index',$data,true);


		$this->load->view('layouts/main',$var);
	}
	public function index_profile()
	{
		if(!empty($this->session->userdata('pwd'))){
			redirect(base_url('index.php/pembayaran/detail_pembayaran'));
		}
        $data['bukatutup'] = $this->db->order_by('id','desc')->limit(1)->get("tb_bukatutup")->row();
		$data['jenis_pembayaran'] = $this->jenis->get_all();
		$data['bank_pengirim'] = $this->bank->get_all();
        $data['siswa'] = $this->siswa->get_all();
        $data['kode'] = $this->siswa->get_kelas_all();
		$data['bulan'] = $this->bulan;
		$var['title'] = 'PPATQ Roudlotul Falah';
		$var['content'] = $this->load->view('pembayaran/index_profile',$data,true);


		$this->load->view('layouts/main',$var);
	}
	public function check_verifikasi_profile(){
		// if(!empty($this->session->userdata('siswa_id'))){
		// 	redirect(base_url('index.php/pembayaran/detail_pembayaran'));
		// }
		if(empty($this->input->post('nama_santri'))){
			$this->session->set_flashdata('error','Nama Santri atau kode belum diisi');
			redirect(base_url('index.php/pembayaran/index_profile'));
		}else{
			$verifikasi = $this->siswa->verifikasi_siswa();
			if($verifikasi){
				$siswa_id = $this->input->post("nama_santri");
				$kode = $this->input->post("kode");
				//$periode = $this->input->post("periode");
				$data['siswa'] = $this->siswa->get_by_ni($siswa_id);
				
				if($data['siswa']->password != md5($this->input->post('password'))){
					$this->session->set_flashdata('error','Password yang di masukan salah');
					redirect(base_url('index.php/pembayaran/index_profile'));
				}
				
				$this->session->set_userdata('siswa_id', $data['siswa']->no_induk);
				$this->session->set_userdata('kode', $kode);
				$this->session->set_userdata('pwd', $data['siswa']->password);
				redirect(base_url('index.php/profile'));
			}else{
				$this->session->set_flashdata('error','Nama Santri dengan kode tidak cocok');
				redirect(base_url('index.php/pembayaran/index_profile'));
			}
		}
	}
	public function detail_pembayaran(){
		//if(!empty($this->session->userdata('siswa_id'))){
		if(!empty($this->input->post('nama_santri'))){
			// $siswa_id = $this->session->userdata('siswa_id');
			// $kode = $this->session->userdata('kode');
			// $periode = $this->session->userdata('periode');
			$siswa_id = $this->input->post('nama_santri');
			$kode = $this->input->post('kode');
			$periode = $this->input->post('periode');
			$verifikasi = $this->siswa->verifikasi_siswa();
		
			if($verifikasi){
				$this->session->set_userdata('siswa_id', $siswa_id);
				$this->session->set_userdata('kode', $kode);
				$this->session->set_userdata('periode', $periode);
			}else{
				$this->session->set_flashdata('error','Santri dan Kelas tidak sesuai');
				redirect(base_url('index.php/pembayaran'));
			}
		}else{
			if(!empty($this->session->userdata('siswa_id'))){
				$siswa_id = $this->session->userdata('siswa_id');
				$kode = $this->session->userdata('kode');
				$periode = $this->session->userdata('periode');
			}else{
				$this->session->set_flashdata('error','Harap Isi form terlebih dahulu');
				redirect(base_url('index.php/pembayaran'));
			}
		}
		
		$data['nama_santri'] = $siswa_id;
		$data['kode'] = $kode;
		
		$data['jenis_pembayaran'] = $this->jenis->get_all();
		$data['bank_pengirim'] = $this->bank->get_all();
		$data['siswa'] = $this->siswa->get_by_ni($data['nama_santri']);
		$data['wali_kelas'] = $this->db->where('code',strtolower($kode))->join('employee_new','employee_new.id=ref_kelas.employee_id')->get('ref_kelas')->row();
		$data['periode'] = $periode;
		
		$data['bulan'] = $this->bulan; 
		
		$data['tunggakan'] = $this->tunggakan->get_by_santri($data['nama_santri']);
		$data['jumlah_tunggakan'] = $this->tunggakan->get_all_tunggakan($data['nama_santri']);
		//$data['kode'] = $this->siswa->get_kelas_all();
		$data['pembayaran'] = $this->pembayaran->get_by_santri($data['nama_santri']);
		$data['pembayaran_bulan'] = $this->pembayaran->get_by_santri_periode_tahun($data['nama_santri'],$periode,date('Y'));
		$data['detail_pembayaran'] = array();
		foreach($data['pembayaran'] as $pembayaran){
			foreach($data['jenis_pembayaran'] as $jenis){
				$data['detail_pembayaran'][$pembayaran->id][$jenis->id] = 0;
			}
			$detail = $this->detail_pembayaran->get_by_id_pembayaran($pembayaran->id);
			foreach($detail as $row){
				$data['detail_pembayaran'][$pembayaran->id][$row->id_jenis_pembayaran] = $row->nominal;
			}
		}
		$data['siswa2'] = $this->siswa->get_by_ni2($data['nama_santri']);	
		$data['photo'] = base_url('assets/images/user.png');
		if(!empty($data['siswa2']->photo) && $data['siswa2']->photo_location == "1" ){
			$data['photo'] = base_url('assets/upload/user/' . $data['siswa2']->photo);
		}elseif(!empty($data['siswa2']->photo) && $data['siswa2']->photo_location == "2" ){
			$data['photo'] = "https://manajemen.ppatq-rf.id/assets/img/upload/photo/" . $data['siswa2']->photo;
		}
		$data['photo_wakel'] = base_url('assets/images/user.png');
		$data['photo_murroby'] = base_url('assets/images/user.png');
		$data['wakel'] = array();
		$data['murroby'] = array();
		$data['kelas'] = array();
		$data['kamar'] = array();
		if(!empty($data['siswa2']->kelas)){
			$kelas = $this->db->get_where('ref_kelas',array('code'=>$data['siswa2']->kelas))->row();
			$pegawai = $this->db->get_where('employee_new',array('id'=>$kelas->employee_id))->row();
			if(!empty($pegawai->photo)){
				$data['photo_wakel'] = 'https://manajemen.ppatq-rf.id/assets/img/upload/photo/' . $pegawai->photo;
				
			}
			$data['wakel'] = $pegawai;
			$data['kelas'] = $kelas;
		}

		if(!empty($data['siswa2']->kamar_id)){
			$kamar = $this->db->get_where('ref_kamar',array('id'=>$data['siswa2']->kamar_id))->row();
			$pegawai = $this->db->get_where('employee_new',array('id'=>$kamar->employee_id))->row();
			if(!empty($pegawai->photo)){
				$data['photo_murroby'] = 'https://manajemen.ppatq-rf.id/assets/img/upload/photo/' . $pegawai->photo;
			}
			$data['murroby'] = $pegawai;
			$data['kamar'] = $kamar;
		}

		$data['berkas'] = $this->db->where('no_induk',$siswa_id)->get('tb_berkas_pendukung')->row();
		$var['title'] = 'PPATQ Roudlotul Falah';
		
		$var['content'] = $this->load->view('pembayaran/detail_pembayaran',$data,true);
		$this->load->view('layouts/main',$var);
	}
    public function simpan(){

        $bukti = explode(".",$_FILES['bukti']['name']);
        $ext = end($bukti);

        $id_santri = $this->input->post('nama_santri');
		$periode = $this->input->post('periode');
		$tahun = $this->input->post('tahun');
		$cek_nomor = $this->db->where(['nama_santri'=>$id_santri,'periode'=>$periode,'tahun'=>$tahun])->get('tb_pembayaran')->num_rows();
		$santri = $this->db->where(['no_induk'=>$id_santri])->get("ref_siswa")->row();
		$santri_detail = $this->db->where(['no_induk'=>$id_santri,"status"=>0])->get("santri_detail")->row();
		$nama_santri = $santri->nama;
		$kelas = $santri->kode;
        $filename = $periode . "-" . $tahun . "-" . $nama_santri . "-" . ($cek_nomor+1);

        $config['upload_path']          = './assets/upload';
        $config['allowed_types']        = '*';
        $config['max_size']             = 10000;
        $config['file_name']            = $filename;

        $this->load->library('upload', $config);

        $verifikasi = $this->siswa->verifikasi_siswa();
        if($verifikasi){
            
            if ( ! $this->upload->do_upload('bukti')){
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('error',$error['error']);

                redirect(base_url('index.php/pembayaran'));
            }else{
				$verifikasi_jumlah = $this->pembayaran->verifikasi_jumlah();
				
				if($verifikasi_jumlah == false){
					$this->session->set_flashdata('error',"Total pembayaran dan rincian pembayaran tidak sama");
					redirect(base_url('index.php/pembayaran/detail_pembayaran'));
				}
                $insert = $this->pembayaran->insert();
                if($insert == 1){
                    $data = $this->upload->data();
                    $filename = $data['file_name'];
					
					if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' ){
						//Compress Image
						$config['image_library']='gd2';
						$config['source_image']='./assets/upload/'.$filename;
						$config['create_thumb']= FALSE;
						$config['maintain_ratio']= FALSE;
						$config['quality']= '50%';
						$config['width']= 600;
						$config['height']= 400;
						$config['new_image']= './assets/upload/'.$filename;
						$this->load->library('image_lib', $config);
						$this->image_lib->resize();
					}
					//insert to db
                    $id = $this->db->order_by('id','desc')->limit(1)->get('tb_pembayaran')->row()->id;
                    $data = array(
                        'bukti' => $filename,
                    );
                    $where = array(
                        'id' => $id,
                    );
                    $update = $this->db->update('tb_pembayaran',$data,$where);
					$insert_tunggakan = $this->b_tunggakan->insert($id_santri, $id);
					
					$no_wa = $this->input->post('no_wa');
					$atas_nama = $this->input->post('atas_nama');
					$jumlah = $this->input->post('jumlah');
					
$msg_old = 'untuk santri/wati ' . $nama_santri . ' kelas ' . $kelas . ' sebesar';
					$message = '[ dari payment.ppatq-rf.id ]


Yth. Bp/Ibu *' . $atas_nama . '*, Wali Santri *' . $santri_detail->nama . '* kelas *' . $santri_detail->kelas . '* telah melakukan melaporkan  pembayaran bulan *' . $this->bulan[(int)$this->input->post('periode')] . '* sebesar Rp. ' . $jumlah . '
dengan rincian sbb : 
';
$jenis = $this->jenis->get_all();
$list_jenis = array();
foreach($jenis as $row){
	$list_jenis[$row->id] = $row->jenis;
}
$detail = $this->detail_pembayaran->get_by_id_pembayaran($id);
foreach($detail as $row){
	$message .= '• ' . $list_jenis[$row->id_jenis_pembayaran] .' sebesar Rp. ' . number_format($row->nominal,0,',','.') . ' 
';

}
$message .= '
Tunggu beberapa waktu, kami akan melakukan pencatatan & segera memberikan status pembayaran tersebut.
';
$message .= '
Riwayat Pelaporan : 
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
						$pembayaran = $this->db->where('MONTH(tanggal_bayar)',$new_bulan)->where('YEAR(tanggal_bayar)',$tahun)->where('validasi',1)->where('nama_santri',$id_santri)->where('is_hapus',0)->get('tb_pembayaran')->result();
						
						foreach($pembayaran as $row){
							$message .= '*' . $this->bulan[$new_bulan] .'* ';
							$message .= $row->tanggal_bayar .' : Rp. ' . number_format($row->jumlah,0,',','.') . '
';
						}
					}
					$message .= '
Bila ada yang perlu diklarifikasi dapat menghubungi  WA di nomor +62877-6757-2025. 
untuk penyampaian masukan melalui https://saran.ppatq-rf.id
Informasi mengenai berita dan detail santri dapat diakses melalui https://ppatq-rf.id
';

$message .= '
----agenda sampai akhir tahun----
';
$tanggal_start_agenda = date('Y-m-d');
$agenda = $this->db->where('tanggal_mulai >=',$tanggal_start_agenda)->get('agenda')->result();
// echo $this->db->last_query();
foreach($agenda as $rows){
	$message .= $rows->judul .'
';
	$message .= date('d-m-Y',strtotime($rows->tanggal_mulai)) . ' - ' . date('d-m-Y',strtotime($rows->tanggal_selesai)) . '
';
}

$message .= '
Kami ucapkan banyak terima kasih kepada (Bp/Ibu) ' . $atas_nama . ', salam kami kepada keluarga.

Semoga pekerjaan dan usahanya diberikan kelancaran dan menghasilkan Rizqi yang banyak dan berkah, aamiin.
';
                    if($update){
                       /*  echo "berhasil";
                        echo $this->db->last_query(); */
						$dataSending = Array();
						$dataSending["api_key"] = "X2Y7UZOZT0WVQVTG";
						$dataSending["number_key"] = "h08N34zrhx44EuP8";
						$dataSending["phone_no"] = $no_wa;
						$dataSending["message"] = $message;

						$curl = curl_init();
						
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

						//kirim ulang ke ust muhadi
						$no_wa = "087767572025";
						$dataSending = Array();
						$dataSending["api_key"] = "X2Y7UZOZT0WVQVTG";
						$dataSending["number_key"] = "h08N34zrhx44EuP8";
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

						$pembayaran = $this->db->where('id',$id)->get('tb_pembayaran')->row();
						$siswa = $this->db->where('id',$pembayaran->nama_santri)->get('ref_siswa')->row();
						$convert_res = json_decode($response);
						$status = 0;
						if($convert_res->status == 200){
							$status = 1;
						}
						$data = array(
							'id_pembayaran' => $id,
							'nama' => $atas_nama,
							'no_wa' => $no_wa,
							'pesan' => $message,
							'status' => $status,
						);
						$hasil = $this->db->insert('tb_send_wa',$data);

						//echo $response;
						$this->session->set_flashdata('message','data berhasil disimpan');
                    }else{
                        $this->session->set_flashdata('message', $this->db->error_message());
                    }
					//echo nl2br($message);
                    //echo $id;
                    //exit;
                    redirect(base_url('index.php/pembayaran/konfirmasi_pembayaran/' . $id));
                }elseif($insert == 2){
					$this->session->set_flashdata('error','Maaf data sudah pernah dimasukan');
					redirect(base_url('index.php/pembayaran/detail_pembayaran'));
				}else{	
					$this->session->set_flashdata('error','Data gagal disimpan');
                    redirect(base_url('index.php/pembayaran/detail_pembayaran'));
                }
            }
        }else{
            $this->session->set_flashdata('error','Nama Santri dengan kode tidak cocok');
            redirect(base_url('index.php/pembayaran'));
        }
    }
	public function print_bukti($id){
		$data['pembayaran'] = $this->pembayaran->get_by_id($id);
        $data['jenis_pembayaran'] = $this->jenis->get_all();
        $data['bank_pengirim'] = $this->bank->get_by_id($data['pembayaran']->bank_pengirim);
        $data['santri'] = $this->siswa->get_by_ni($data['pembayaran']->nama_santri);
        $data['bulan'] = $this->bulan;
        
        $data['detail_pembayaran'] = array();
        foreach($data['jenis_pembayaran'] as $jenis){
            $data['detail_pembayaran'][$jenis->id] = 0;
        }

        $detail = $this->detail->get_by_id_pembayaran($id);
        foreach($detail as $row){
            $data['detail_pembayaran'][$row->id_jenis_pembayaran] = $row->nominal;
        }
		
		$this->load->library('pdf');
		$this->data['title_pdf'] = 'Tagihan Santri';
        
        $this->pdf->setPaper('A6', 'potrait');
		$this->pdf->set_option('isRemoteEnabled',true);
        $this->pdf->filename = "bukti_pembayaran_santri.pdf";
        
		$this->pdf->load_view('admin/pembayaran/print',$data, true);	    
		//$this->load->view('admin/pembayaran/print',$data);	    
        
        // run dompdf
        // /$this->pdfgenerator->generate($html, $file_pdf, $paper,$orientation);
	}
	public function konfirmasi_pembayaran($id){
		$data['id'] = $id;
		$pembayaran = $this->db->where('id',$id)->get('tb_pembayaran')->row();
		$siswa = $this->db->where('no_induk',$pembayaran->nama_santri)->get('ref_siswa')->row();
		$kode = $siswa->kode;
		$data['siswa'] = $siswa;
		$data['kode'] = $kode;
		$data['wali_kelas'] = $this->db->where('code',strtolower($kode))->join('employee_new','employee_new.id=ref_kelas.employee_id')->get('ref_kelas')->row();
		
		$var['title'] = 'PPATQ Roudlotul Falah';
				
		$var['content'] = $this->load->view('pembayaran/konfirmasi_pembayaran',$data,true);
		
		$this->load->view('layouts/main',$var);
	}
	/* public function test_send_wa(){
		
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.watzap.id/v1/send_message',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>'{
			"api_key": "X2Y7UZOZT0WVQVTG",
			"number_key": "vqD6atiieyOOx7CI",
			"phone_no": "6285975122304",
			"message": "test"
		}',
		  CURLOPT_HTTPHEADER => array(
			'Content-Type: application/json'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		echo $response;
	} */
	/* public function generate_password_siswa(){
		$siswa = $this->db->get('ref_siswa')->result();
		$jumlah = 0;
		foreach($siswa as $row){
			$detail = $this->db->where('no_induk',$row->no_induk)->get('tb_siswa_detail')->row();
			$tanggal_lahir = (!empty($detail->tanggal_lahir))?$detail->tanggal_lahir:date('Ymd');
			$tanggal = date('dmy', strtotime($tanggal_lahir));
			$gabung = $tanggal . strtoupper($detail->jenis_kelamin);
			//echo $detail->tanggal_lahir;
			$data = array(
				'password' => md5($gabung),
			);
			$where = array(
				'id' => $row->id,
			);
			$hasil = $this->db->update('ref_siswa',$data,$where);
			if($hasil){
				$jumlah++;
			}
		}
	} */
	
	public function get_riwayat(){
		$bulan = $this->input->post('bulan');
		$nama_santri = $this->input->post('nama_santri');
		$data['jenis_pembayaran'] = $this->jenis->get_all();
		$data['pembayaran'] = $this->pembayaran->get_by_santri($nama_santri);
		$data['bulan'] = $this->bulan; 
		$data['detail_pembayaran'] = array();
		foreach($data['pembayaran'] as $pembayaran){
			foreach($data['jenis_pembayaran'] as $jenis){
				$data['detail_pembayaran'][$pembayaran->id][$jenis->id] = 0;
			}
			$detail = $this->detail_pembayaran->get_by_id_pembayaran($pembayaran->id);
			foreach($detail as $row){
				$data['detail_pembayaran'][$pembayaran->id][$row->id_jenis_pembayaran] = $row->nominal;
			}
		}
		$this->load->view('pembayaran/tbl_riwayat',$data);
	}
	public function ini_php(){
		phpinfo();
	}
	
}

