<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran extends CI_Controller {

    public function __construct(){
        parent::__construct();
        if(empty($this->session->userdata('roles'))){
            redirect(base_url('index.php/auth/login'));
        }else{
            if($this->session->userdata('roles') != 'Admin'){
                redirect(base_url('index.php/auth/login'));
            }
        }
        $this->load->model('Pembayaran_model','pembayaran');
        $this->load->model('Detail_pembayaran_model','detail');
        $this->load->model('Bank_model','bank');
        $this->load->model('Siswa_model','siswa');
        $this->load->model('Jenis_model','jenis');
		$this->load->model('Detail_pembayaran_model','detail_pembayaran');
		$this->load->model('Tunggakan_model','tunggakan');
		$this->load->model('Pembayaran_tunggakan_model','b_tunggakan');
		$this->load->model('Wa_model','wa');

		error_reporting(0);
		
    }
	
	public $bulan = array(1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
	
    public function index(){
		$data['pembayaran'] = "";
		if($this->input->post('periode') !== null){
			$bulan = $this->input->post('periode');
			$tahun = $this->input->post('tahun');
			$_SESSION['bulan'] = $bulan;
			$_SESSION['tahun'] = $tahun;
		}else{
			if(!empty($_SESSION['bulan'])){
				$bulan = $_SESSION['bulan'];
				$tahun = $_SESSION['tahun'];
			}else{
				$bulan = date('m');
				$tahun = date('Y');
			}
		}			
			$data['pembayaran'] = $this->pembayaran->get_by_periode($bulan,$tahun);

			$bank = $this->bank->get_all();
			$data['bank'] = array();
			$data['bank'][0] = "Cash";
			foreach($bank as $row){
				$data['bank'][$row->id] = $row->nama;
			}
			
			$siswa = $this->siswa->get_all();
			$data['siswa'] = array();
			$data['kelas'] = array();
			foreach($siswa as $row){
				$data['siswa'][$row->no_induk] = $row->nama;
				$data['kelas'][$row->no_induk] = $row->kode;
			}
			$data['curr_bulan'] = $bulan;
			$data['curr_tahun'] = $tahun;
		/* }else{		
			
				
				$data['pembayaran'] = $this->pembayaran->get_by_periode($bulan,$tahun);

				$bank = $this->bank->get_all();
				$data['bank'] = array();
				$data['bank'][0] = "Cash";
				foreach($bank as $row){
					$data['bank'][$row->id] = $row->nama;
				}
				
				$siswa = $this->siswa->get_all();
				$data['siswa'] = array();
				$data['kelas'] = array();
				foreach($siswa as $row){
					$data['siswa'][$row->id] = $row->nama;
					$data['kelas'][$row->id] = $row->kode;
				}
				$data['curr_bulan'] = $bulan;
				$data['curr_tahun'] = $tahun;
			}
		} */
        $data['bulan'] = $this->bulan;
		
		$var['title'] = 'Daftar Pembayaran';
		$var['content'] = $this->load->view('admin/pembayaran/index',$data,true);

		$this->load->view('layouts/admin',$var);
		

		
    }
    public function show($id){
		
        $data['pembayaran'] = $this->pembayaran->get_by_id($id);

        $bank = $this->bank->get_all();
        $data['bank'] = array();
        $data['bank'][0] = "Cash";
        foreach($bank as $row){
            $data['bank'][$row->id] = $row->nama;
        }
        
        $siswa = $this->siswa->get_all();
        $data['siswa'] = array();
		$data['kode_kamar'] = 0;
        foreach($siswa as $row){
            $data['siswa'][$row->no_induk] = $row->nama;
			
        }
		$santri_detail = $this->db->where('no_induk',$data['pembayaran']->nama_santri)->get('santri_detail')->row();
		if(!empty($santri_detail->kamar_id)){
			$data['kode_kamar'] = $santri_detail->kamar_id;
		}
		
		$data['kode_murroby'] = "";
		$data['nama_murroby'] = "";
		if($data['kode_kamar'] != 0){
			$kamar = $this->db->where('id',$data['kode_kamar'])->get('ref_kamar')->row();
			$data['kode_murroby'] = $kamar->code;
			$data['nama_murroby'] = $this->db->where('id',$kamar->employee_id)->get('employee_new')->row()->nama;
		}

        $jenis = $this->jenis->get_all();
        $data['jenis'] = array();
        foreach($jenis as $row){
            $data['jenis'][$row->id] = $row->jenis;
        }

        $data['detail'] = $this->detail->get_by_id_pembayaran($id);

		$var['title'] = 'Detail Pembayaran';
		$var['content'] = $this->load->view('admin/pembayaran/show',$data,true);

		$this->load->view('layouts/admin',$var);
    }
    
    public function laporan(){
        if(!empty($this->input->post('periode'))){
            $periode = $this->input->post('periode');
            $tahun = $this->input->post('tahun');
            $data['jenis_pembayaran'] = $this->jenis->get_all();
            $data['siswa'] = $this->siswa->get_all_detail();
            $pembayaran = $this->pembayaran->get_by_periode($periode,$tahun);
            $santri = array();
            //inisiasi
            foreach($data['siswa'] as $siswa){
                foreach($data['jenis_pembayaran'] as $jenis_pembayaran){
                    $santri[$siswa->no_induk][$jenis_pembayaran->id] = 0;
                }
            }
            //assign nilai di dalamnya
            foreach($pembayaran as $row){
                $detailPembayaran = $this->detail->get_by_id_pembayaran($row->id);
                foreach($detailPembayaran as $detail){
					$santri[$row->nama_santri][$detail->id_jenis_pembayaran] += $detail->nominal;
                }
            }
            // var_dump($santri[5]);
            // exit;

			$kamar = $this->db->get('ref_kamar')->result();
			$data['nama_murroby'] = array();
			foreach($kamar as $row){
				$data['nama_murroby'][$row->id] = $this->db->get_where('employee_new',array('id'=>$row->employee_id))->row()->nama;
			}


            $bulan = array(1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
            $data['bulan'] = $bulan;
            $data['santri'] = $santri;
            $data['periode'] = $periode;
            $data['tahun'] = $tahun;
            $var['title'] = 'Syahriyah ' . $bulan[$periode] . ' ' . $tahun;
            $var['content'] = $this->load->view('admin/pembayaran/laporan',$data,true);

            $this->load->view('layouts/admin',$var);
        }else{
            $data = '';
            $var['title'] = 'Daftar Pembayaran';
            $var['content'] = $this->load->view('admin/pembayaran/laporan',$data,true);

            $this->load->view('layouts/admin',$var);
        }
    }
    public function create(){
        $data['jenis_pembayaran'] = $this->jenis->get_all();
		$data['bank_pengirim'] = $this->bank->get_all();
        $data['siswa'] = $this->siswa->get_all();
        $data['kode'] = $this->siswa->get_kelas_all();
		$data['bulan'] = $this->bulan;
		$data['bulan'] = $this->bulan;
		$var['title'] = 'Tambah Pembayaran';
        $var['content'] = $this->load->view('admin/pembayaran/create',$data,true);
		

        $this->load->view('layouts/admin',$var);
    }
	public function simpan(){
		$bukti = explode(".",$_FILES['bukti']['name']);
        $ext = end($bukti);
		$id_santri = $this->input->post('nama_santri');
		$periode = $this->input->post('periode');
		$tahun = $this->input->post('tahun');
		$cek_nomor = $this->db->where(['nama_santri'=>$id_santri,'periode'=>$periode,'tahun'=>$tahun])->get('tb_pembayaran')->num_rows();
		$nama_santri = $this->db->where(['no_induk'=>$id_santri])->get("santri_detail")->row()->nama;
        $filename = $periode . "-" . $tahun . "-" . $nama_santri . "-" . ($cek_nomor+1);
		/* echo $filename;
		exit; */

        $config['upload_path']          = './assets/upload';
        $config['allowed_types']        = 'gif|jpg|jpeg|png|bmp|pdf';
        $config['max_size']             = 30000;
        $config['file_name']            = $filename;

        $this->load->library('upload', $config);
            
		$this->upload->do_upload('bukti');

        $insert = $this->pembayaran->insert_admin();
        if($insert){
            $data = $this->upload->data();
            $filename = $data['file_name'];
            
			if($ext == 'jpeg' || $ext == 'jpg' || $ext == 'png' ){
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
			
            $id = $this->db->order_by('id','desc')->limit(1)->get('tb_pembayaran')->row()->id;
            $data = array(
                'bukti' => $filename,
            );
            $where = array(
                'id' => $id,
            );
            $update = $this->db->update('tb_pembayaran',$data,$where);
			
			$validasi = $this->input->post('validasi');
			if($validasi == 1){
				
				$insert_tunggakan = $this->b_tunggakan->insert_admin($id_santri, $id);
			}else{
				$insert_tunggakan = $this->b_tunggakan->insert($id_santri, $id);
			}
			
			$wa = $this->wa->validasi_admin($id,$validasi);
			
			
            if($update){
                //echo "berhasil";
                //echo $this->db->last_query();
                $this->session->set_flashdata('message','data berhasil disimpan');
                redirect(base_url('index.php/admin/pembayaran'));
            }else{
                $error = $this->db->_error_message();
                $this->session->set_flashdata('error',$error);
                redirect(base_url('index.php/admin/pembayaran/create'));
            }
        }else{
            redirect(base_url('index.php/admin/pembayaran/create'));
        }
        
	}
	public function new_validasi($id,$status){
		$validasi = $this->pembayaran->get_by_id($id)->validasi;
        $new_validasi = $status;
		$pembayaran = $this->db->where('id_pembayaran',$id)->get('tb_pembayaran_tunggakan');
		
        $wa = $this->wa->validasi($id,$new_validasi);
        
		if($pembayaran->num_rows() > 0){
			if($validasi == 0 && $new_validasi == 1){
				//memasukan data ke tunggakan dari sebelumnya blm validasi jadi valid
				$tambah = $this->b_tunggakan->status_valid($id);
				//kirim wa message
				
			}elseif($validasi == 1 && $new_validasi == 0){
				$tambah = $this->b_tunggakan->status_invalid($id);
			}elseif($validasi == 2 && $new_validasi == 1){
				$tambah = $this->b_tunggakan->status_valid($id);
			}elseif($validasi == 1 && $new_validasi == 2){
				$tambah = $this->b_tunggakan->status_invalid($id);
			}
		}
		$update = $this->pembayaran->new_validasi($id,$status);
		//cek uang saku id=3  dan validasi = =valid
		$pembayaran = $this->db->where('id',$id)->get('tb_pembayaran')->row();
		$detail = $this->db->where('id_pembayaran',$id)->get('tb_detail_pembayaran')->result();
		$uang_saku = $this->db->where('no_induk',$pembayaran->nama_santri)->get('tb_uang_saku')->row();
		if($validasi == 0 && $new_validasi == 1){
			//jika status diubah menjadi valid
			foreach($detail as $row){
				if($row->id_jenis_pembayaran == 3){
					$cek_saku_masuk = $this->db->where('id_pembayaran',$id)->get('tb_saku_masuk');
					if($cek_saku_masuk->num_rows() > 0){
						$data = [
							'status_pembayaran'=>1,
						];
						$where = [
							'id_pembayaran'=>$id,
						];
						$this->db->update('tb_saku_masuk',$data,$where);

						$data2 = array(
							'jumlah' => $uang_saku->jumlah + $row->nominal
						);
						$this->db->update('tb_uang_saku',$data2,array('no_induk'=>$pembayaran->nama_santri));
					}else{
						$data = array(
							'dari' => 1,
							'jumlah' => $row->nominal,
							'tanggal' => $pembayaran->tanggal_bayar,
							'no_induk' => $pembayaran->nama_santri,
							'id_pembayaran' => $id,
							'status_pembayaran' => 1,
						);
						$this->db->insert('tb_saku_masuk',$data);
						$data2 = array(
							'jumlah' => $uang_saku->jumlah + $row->nominal
						);
						$this->db->update('tb_uang_saku',$data2,array('no_induk'=>$pembayaran->nama_santri));
					}
				}
			}
		}elseif(($validasi == 1 && $new_validasi == 2) || ($validasi == 1 && $new_validasi == 0)){
			//Jikas status diubah menjadi tidak valid
			foreach($detail as $row){
				if($row->id_jenis_pembayaran == 3){
					$cek_saku_masuk = $this->db->where('id_pembayaran',$id)->get('tb_saku_masuk');
					if($cek_saku_masuk->num_rows() > 0){
						$data = [
							'status_pembayaran'=>0,
						];
						$where = [
							'id_pembayaran'=>$id,
						];
						$this->db->update('tb_saku_masuk',$data,$where);

						$data2 = array(
							'jumlah' => $uang_saku->jumlah - $row->nominal
						);
						$this->db->update('tb_uang_saku',$data2,array('no_induk'=>$pembayaran->nama_santri));
					}else{
						$data = array(
							'dari' => 1,
							'jumlah' => $row->nominal,
							'tanggal' => $pembayaran->tanggal_bayar,
							'no_induk' => $pembayaran->nama_santri,
							'id_pembayaran'=>$id,
							'status_pembayaran' => 0,
						);
						$this->db->insert('tb_saku_masuk',$data);
						
					}
				}
			}
		}

		//echo $validasi . " " . $new_validasi;
		$convert_wa = json_decode($wa);
        if($update){
            //$this->session->set_flashdata('message','data berhasil diupdate ' . $wa);
            redirect(base_url('index.php/admin/pembayaran/show/' . $id));
        }else{
            $this->session->set_flashdata('error','data berhasil ditambahkan');
            redirect(base_url('index.php/admin/pembayaran/show/' . $id));
        }
	}
    public function edit($id){
        $data['pembayaran'] = $this->pembayaran->get_by_id($id);
        $data['jenis_pembayaran'] = $this->jenis->get_all();
        $data['bank_pengirim'] = $this->bank->get_all();
        $data['siswa'] = $this->siswa->get_all();
        $data['nama_santri'] = $this->siswa->get_by_ni($data['pembayaran']->nama_santri)->nama;
        
        
        $data['detail_pembayaran'] = array();
        foreach($data['jenis_pembayaran'] as $jenis){
            $data['detail_pembayaran'][$jenis->id] = 0;
        }

        $detail = $this->detail->get_by_id_pembayaran($id);
        foreach($detail as $row){
            $data['detail_pembayaran'][$row->id_jenis_pembayaran] = $row->nominal;
        }
		
		//$data['jumlah_tunggakan'] = $this->tunggakan->get_all_tunggakan($data['nama_santri']);
		$data['tunggakan'] = $this->tunggakan->get_by_santri($data['nama_santri']);
        

		$var['title'] = 'Edit Pembayaran';
		$var['content'] = $this->load->view('admin/pembayaran/edit',$data,true);

		$this->load->view('layouts/admin',$var);
    }
    public function update(){
		
		$id_santri = $this->input->post('nama_santri');
		$periode = $this->input->post('periode');
		$tahun = $this->input->post('tahun');
		
        if($_FILES['bukti']['size'] != 0){
			$bukti = explode(".",$_FILES['bukti']['name']);
            $ext = end($bukti);
			$cek_nomor = $this->db->where(['nama_santri'=>$id_santri,'periode'=>$periode,'tahun'=>$tahun])->get('tb_pembayaran')->num_rows();
			$nama_santri = $this->db->where(['id'=>$id_santri])->get("ref_siswa")->row()->nama;
			$filename = $periode . "-" . $tahun . "-" . $nama_santri . "-" . ($cek_nomor+1);
            //$filename = md5(date('Y-m-d H:i:s'));

            $config['upload_path']          = './assets/upload';
            $config['allowed_types']        = 'gif|jpg|jpeg|png|bmp|pdf';
            $config['max_size']             = 10000;
            $config['file_name']            = $filename;

            $this->load->library('upload', $config);
                
            $this->upload->do_upload('bukti');
        }

        $pembayaran = $this->pembayaran->update_admin();
        if($pembayaran){
            if($_FILES['bukti']['size'] != 0){
                $data = $this->upload->data();
                $filename = $data['file_name'];
                
                $id = $this->input->post('id');
                $data = array(
                    'bukti' => $filename,
                );
                $where = array(
                    'id' => $id,
                );
                $update = $this->db->update('tb_pembayaran',$data,$where);
                if($update){
                    //echo "berhasil";
                    //echo $this->db->last_query();
                    $this->session->set_flashdata('message','data berhasil disimpan');
                    redirect(base_url('index.php/admin/pembayaran'));
                }else{
                    $error = $this->db->_error_message();
                    $this->session->set_flashdata('error',$error);
                    redirect(base_url('index.php/admin/pembayaran/create'));
                }
            }else{
                $this->session->set_flashdata('message','data berhasil disimpan');
                redirect(base_url('index.php/admin/pembayaran'));
            }
            
        }else{
            redirect(base_url('index.php/admin/pembayaran/create'));
        }
        
	}
    public function delete($id){
        $delete = $this->pembayaran->delete($id);
        if($delete){
            $this->session->set_flashdata('message','data berhasil dihapus');
            redirect(base_url('index.php/admin/pembayaran'));
        }else{
            redirect(base_url('index.php/admin/pembayaran/'));
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
	}
	public function import(){
		$list_pembayaran = $this->input->post('list_pembayaran');
		$hasil = json_decode($list_pembayaran);
		$insert = $this->pembayaran->insert_json($hasil);
		if($insert){
			$this->session->set_flashdata('message','data berhasil ditambahkan');
			//redirect(base_url('index.php/admin/pembayaran'));
		}else{
			$this->session->set_flashdata('error','Data gagal masuk ke database');
			//redirect(base_url('index.php/admin/pembayaran'));
		}
	}
	public function get_riwayat(){
		$data['nama_santri'] = $this->input->post('nama_santri');
		$data['periode'] = $this->input->post('periode');
		$data['jenis_pembayaran'] = $this->jenis->get_all();
		$data['pembayaran'] = $this->pembayaran->get_by_santri_periode($data['nama_santri'],$data['periode']);
		$data['detail_pembayaran'] = array();
		$data['bulan'] = $this->bulan;
		foreach($data['pembayaran'] as $pembayaran){
			foreach($data['jenis_pembayaran'] as $jenis){
				$data['detail_pembayaran'][$pembayaran->id][$jenis->id] = 0;
			}
			$detail = $this->detail_pembayaran->get_by_id_pembayaran($pembayaran->id);
			foreach($detail as $row){
				$data['detail_pembayaran'][$pembayaran->id][$row->id_jenis_pembayaran] = $row->nominal;
			}
		}
		return $this->load->view('admin/pembayaran/riwayat',$data);
	}
	public function get_jumlah_tunggakan(){
		$nama_santri = $this->input->post('nama_santri');
		$jumlah_tunggakan = $this->tunggakan->get_all_tunggakan($nama_santri);
		echo number_format($jumlah_tunggakan,0,",",".");
	}
	public function get_tunggakan(){
		$data['nama_santri'] = $this->input->post('nama_santri');
		$data['tunggakan'] = $this->tunggakan->get_by_santri($data['nama_santri']);
		
		return $this->load->view('admin/pembayaran/tunggakan',$data);
	}
	public function get_wa_form(){
		$id = $this->input->post('id');
		$data['pembayaran'] = $this->pembayaran->get_by_id($id);
		$data['detail_pembayaran'] = $this->detail_pembayaran->get_by_id_pembayaran($id);
		$data['nama_santri'] = $this->siswa->get_by_ni2($data['pembayaran']->nama_santri);
		$data['bulan'] = $this->bulan;
		$jenis = $this->jenis->get_all();
		$data['jenis_pembayaran'] = array();
		foreach($jenis as $row){
			$data['jenis_pembayaran'][$row->id] = $row->jenis;
		}
		$pembayaran = $data['pembayaran'];
		$detail_pembayaran = $data['detail_pembayaran'];
		$santri_detail = $data['nama_santri'];
		$bulan = $data['bulan'];
		$message = '[ dari admin payment.ppatq-rf.id ]
Dapatkan Aplikasi Mobile Wali Santri
https://new.ppatq-rf.sch.id/app-wali-santri

Yth. Bp/Ibu *' . $pembayaran->atas_nama . '*, Wali Santri *' . $santri_detail->nama . '* kelas *' . $santri_detail->kelas . '* telah melaporkan pembayaran bulan *' . $bulan[(int)$pembayaran->periode] . '* 
Rp. ' . $pembayaran->jumlah . ' rincian sbb : 
';
$jenis = $this->jenis->get_all();
$list_jenis = array();
foreach($jenis as $row){
	$list_jenis[$row->id] = $row->jenis;
}
$detail = $detail_pembayaran;
foreach($detail as $row){
	$message .= '• ' . $list_jenis[$row->id_jenis_pembayaran] .' sebesar Rp. ' . number_format($row->nominal,0,',','.') . ' 
';

}
// $message .= '
// Tunggu beberapa waktu, kami akan melakukan pencatatan & segera memberikan status pembayaran tersebut.
// ';
$message .= '
Tunggu beberapa saat, pencatatan akan dilakukan & segera memberikan status pembayaran tersebut.
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
						$pembayaran2 = $this->db->where('MONTH(tanggal_bayar)',$new_bulan)->where('YEAR(tanggal_bayar)',$tahun)->where('validasi',1)->where('nama_santri',$data['pembayaran']->nama_santri)->where('is_hapus',0)->get('tb_pembayaran')->result();
						
						foreach($pembayaran2 as $row){
							$message .= '*' . $this->bulan[$new_bulan] .'* ';
							$message .= $row->tanggal_bayar .' : Rp. ' . number_format($row->jumlah,0,',','.') . '
';
						}
					}
					$message .= '
No. WA konfirmasi di +62877-6757-2025. 

untuk penyampaian masukan melalui https://payment.ppatq-rf.id/index.php/keluhan	

Informasi mengenai berita dan detail santri dapat diakses melalui https://ppatq-rf.id
';
//riwayat kesehatan

$riwayat = $this->db->order_by('id','desc')->limit(5)->get_where('tb_kesehatan',array('santri_id'=>$santri_detail->no_induk))->result();
if($riwayat){
$message .= '
----Riwayat Kesehatan----
';
foreach($riwayat as $rows){
	$message .= $rows->sakit . " ( " . date('d-m-Y',$rows->tanggal_sakit) . " )
";
}
}
//riwayat ketahfidzan

$tahfidz = $this->db->select('detail_santri_tahfidz.*,kode_juz.nama as nama_juz')->order_by("detail_santri_tahfidz.id","desc")->limit(5)->join('kode_juz','kode_juz.id = detail_santri_tahfidz.kode_juz_surah')->get_where('detail_santri_tahfidz',array('no_induk'=>$santri_detail->no_induk))->result();
if($tahfidz){
$message .= '
----Riwayat Ketahfidzan----
';
foreach($tahfidz as $row){
	$message .= $row->nama_juz . "  (" . $this->bulan[$row->bulan] . " " . $row->tahun . " ) 
";
} 
}
$message .= '
----agenda sampai akhir tahun----
';
$tanggal_start_agenda = date('Y-m-d');
$agenda = $this->db->where('tanggal_mulai >=',$tanggal_start_agenda)->order_by("tanggal_mulai", "asc")->get('agenda')->result();
// echo $this->db->last_query();
foreach($agenda as $rows){
	$message .= $rows->judul .'
';
	$message .= date('d-m-Y',strtotime($rows->tanggal_mulai)) . ' - ' . date('d-m-Y',strtotime($rows->tanggal_selesai)) . '
';
}

$message .= '
Kami ucapkan banyak terima kasih kepada (Bp/Ibu) ' . $pembayaran->atas_nama . ', salam kami kepada keluarga.

Semoga pekerjaan dan usahanya diberikan kelancaran dan menghasilkan Rizqi yang banyak dan berkah, aamiin.
';
$data['message'] = $message;
		return $this->load->view('admin/pembayaran/wa_form',$data);
	}
	public function send_wa(){
		$data = array(
			'id_pembayaran' => $this->input->post('id_pembayaran'),
			'nama' => $this->input->post('nama'),
			'no_wa' => $this->input->post('no_wa'),
			'pesan' => $this->input->post('pesan'),
		);
		$hasil = $this->db->insert('tb_send_wa',$data);
        return $this->db->last_insert_id;
	}
	private function send_wa_to_tbl($nama,$no_wa,$pesan){
		$data = array(
			'id_pembayaran' => 0,
			'nama' => $nama,
			'no_wa' => $no_wa,
			'pesan' => $pesan,
		);
		$hasil = $this->db->insert('tb_send_wa',$data);
        return $hasil;
	}
    public function update_status_wa(){
        $data = array(
            'status' => $this->input->post('status')
        );
        return $this->db->update('tb_send_wa',$data,['id'=>$this->input->post('id')]);
    }
    public function migrasi_noinduk(){
        $pembayaran = $this->pembayaran->get_all();
        foreach($pembayaran as $row){
            $siswa = $this->siswa->get_by_id($row->nama_santri);
            echo $siswa->no_induk;
            echo "<br />";

            $data = array(
                'nama_santri' => $siswa->no_induk,
            );

            $update = $this->db->update('tb_pembayaran',$data,array('id'=>$row->id));
            if($update){
                echo "berhasil";
            }else{
                echo "gagal";
            }
            echo "<br />";           
        }
    }
	public function migrasi_no_hp(){
		$all_pembayaran = $this->db->group_by('no_wa')->get('tb_pembayaran')->result();
		foreach($all_pembayaran as $pembayaran){
			$no_hp = $this->db->where('no_hp',$pembayaran->no_wa)->where('no_induk',$pembayaran->nama_santri)->get('ref_no_hp')->num_rows();
			if($no_hp < 1){
				$data = array(
					'no_induk' => $pembayaran->nama_santri,
					'atas_nama' => $pembayaran->atas_nama,
					'no_hp' => $pembayaran->no_wa,
				);
				$insert = $this->db->insert('ref_no_hp',$data);
				if($insert){
					echo $pembayaran->atas_nama . "-" . $pembayaran->nama_santri .  " : " . $pembayaran->no_wa . "berhasil";
					echo "<br />";
				}
			}
		}
		redirect(base_url('index.php/admin/pembayaran/belum_lapor'));
	}
	public function testing_jumlah(){
		$no_hp = $this->db->group_by('no_induk')->get('ref_no_hp')->num_rows();
		
		//cek yang sudah membayar bulan 
		//$bulan = (int)date('m');
		$bulan = 6;
		$tahun = date('Y');
		
		$pembayaran = $this->db->where('periode',$bulan)->where('is_hapus',0)->where('tahun',$tahun)->group_by('nama_santri')->get('tb_pembayaran')->result();
		//simpan ke dalam variabel no_induk yang sudah bayar 
		$no_induk = array();
		foreach($pembayaran as $pem){
			echo $pem->nama_santri . " - " . $pem->no_wa;
			echo "<br />";
			$no_induk[] = $pem->nama_santri;
		}

		//query untuk datpat no_induk yang belum membayar
		echo "yang belum lapor";
		$no_hp = $this->db->where_not_in('no_induk',$no_induk)->get('ref_no_hp')->result();
		foreach($no_hp as $row){
			echo $row->no_induk . " - " . $row->no_hp . "<br />";
		}
	}
	public function belum_lapor(){
		if(empty($this->input->post('periode'))){
			$bulan = date('m');
			$tahun = date('Y');
		}else{
			$bulan = $this->input->post('periode');
			$tahun = $this->input->post('tahun');
		}
		$data['curr_bulan'] = (int)$bulan;
		$data['curr_tahun'] = $tahun;
		
		$pembayaran = $this->db->where('periode',$bulan)->where('is_hapus',0)->where('tahun',$tahun)->group_by('nama_santri')->get('tb_pembayaran')->result();
		//simpan ke dalam variabel no_induk yang sudah bayar 
		$no_induk = array();
		foreach($pembayaran as $pem){
			$no_induk[] = $pem->nama_santri;
		}

		//query untuk datpat no_induk yang belum membayar
		//echo "yang belum lapor";
		$no_hp = $this->db->select('ref_no_hp.*,tb_siswa_detail.nama')->join('tb_siswa_detail','tb_siswa_detail.no_induk = ref_no_hp.no_induk')->group_by('ref_no_hp.no_induk')->where_not_in('ref_no_hp.no_induk',$no_induk)->get('ref_no_hp')->result();
		
		$data['bulan'] = $this->bulan;
		$data['list_hp'] = $no_hp;
		
		$var['title'] = 'Daftar Belum Lapor Pembayaran';
		$var['content'] = $this->load->view('admin/pembayaran/belum_lapor',$data,true);

		$this->load->view('layouts/admin',$var);
	}
	public function kirim_reminder($id){
		$no_hp = $this->db->where('no_induk',$id)->get('ref_no_hp')->result();
		$santri = $this->db->where('no_induk',$id)->get('santri_detail')->row();
		foreach($no_hp as $row){
// 			$pesan = '
// Kepada segenap wali santri PPATQ-RF

// *Assalâmu`alaikum warohamatullohiwabarokatuh*

// Kami atas nama pengurus, bendahara dan diketahui Pengasuh PPATQ-RF memberitahukan kembali, PERATURAN terkait kewajiban Syahriyah dan Saku bulanan santri  bahwa : 

// 1. Wajib membayarkan syahriah dan saku tepat waktu, yaitu *Sebelum tanggal  10 SETIAP BULAN nya*

// 2. Bagi yang melebihi pembayaran di atas tanggal 10 , saku ditangguhkan (khusus yang tak mempunyai saldo) 

// 3. Silakan membayar dengan mode transfer pada rekening yang telah ditentukan yaitu rekening atas nama Pondok Anak Tahfidhul Qur`an, No. Rekening 5936-01-005247-53-0, Bank BRI (kode bank 002), dan selanjutnya mohon dilaporkan bukti transfernya melalui alamat url: payment.ppatq-rf.id

// Demikian beberapa yang perlu kami sampaikan, mohon maaf, apabila walisantri telah melakukan pembayaran / pelaporan, dimohon diabaikan pesan ini.

// Wassalâmu`alaikum warohmatulloh 


// Mengetahui
// Khodimul Ma`had
// K. Noor Shokhib M.Pd.I

// *Pesan ini otomatis dikirim dari sistem manajemen laporan pembayaran*
// ';  
$pesan = '
Assalamualaikum Wr Wb,
Yth Wali Santri ' . $santri->nama . ' (' . $santri->kelas . ')

Mohon maaf atas ketidaknyaman informasi ini. Kami sampaikan bahwa sampai dengan saat ini pada payment.ppatq-rf.id (sistem pelaporan pencatatan pembayaran syahriah), belum ada catatan/bukti pembayaran untuk bulan Desember 2023. Untuk itu, bagi yang belum melakukan pembayaran, kami memohon untuk segera melakukan pembayaran (transfer ke Rek.PPATQ-RF BRI : 5936-01-005247-53-0, kode bank : 002) dan selanjutnya mohon melakukan pelaporan hasil transfer melalui payment.ppatq-rf.id
mengingat pembagian uang saku dilakukan sebelum tanggal 20 setiap bulannya.

Bagi yang sudah melakukan pembayaran/transfer dan pelaporan di payment.ppatq-rf.id kami ucapkan terimakasih sebanyak-banyaknya.

Terimakasih perhatian dan mohon maaf jika ada hal yang kurang berkenan

Wassalamualaikum Wr Wb
';
			$hasil = $this->send_wa_to_tbl($row->atas_nama,$row->no_hp,$pesan);
			if($hasil){
				//kirim dengan menggunakn wa api; 085726553442 no asli
				$data['no_wa'] = $row->no_hp;
				$data['pesan'] = $pesan;
				//$data['url'] = "https://payment.ppatq-rf.id/assets/images/pengumuman.jpeg";
				$send_wa = $this->wa->send_wa($data);
			}
		}
		echo $send_wa;
		//redirect(base_url('index.php/admin/pembayaran/belum_lapor'));
	}
	public function kirim_ke_semua(){
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');

		$pembayaran = $this->db->where('periode',$bulan)->where('is_hapus',0)->where('tahun',$tahun)->group_by('nama_santri')->get('tb_pembayaran')->result();
		//simpan ke dalam variabel no_induk yang sudah bayar 
		$no_induk = array();
		foreach($pembayaran as $pem){
			$no_induk[] = $pem->nama_santri;
		}
		$no_hp = $this->db->select('ref_no_hp.*,santri_detail.nama,santri_detail.kelas')->join('santri_detail','santri_detail.no_induk = ref_no_hp.no_induk')->group_by('ref_no_hp.no_induk')->where_not_in('ref_no_hp.no_induk',$no_induk)->get('ref_no_hp')->result();
		foreach($no_hp as $row){
// 			$pesan = '
// Kepada segenap wali santri PPATQ-RF

// *Assalâmu`alaikum warohamatullohiwabarokatuh*

// Kami atas nama pengurus, bendahara dan diketahui Pengasuh PPATQ-RF memberitahukan kembali, PERATURAN terkait kewajiban Syahriyah dan Saku bulanan santri  bahwa : 

// 1. Wajib membayarkan syahriah dan saku tepat waktu, yaitu *Sebelum tanggal  10 SETIAP BULAN nya*

// 2. Bagi yang melebihi pembayaran di atas tanggal 10 , saku ditangguhkan (khusus yang tak mempunyai saldo) 

// 3. Silakan membayar dengan mode transfer pada rekening yang telah ditentukan yaitu rekening atas nama Pondok Anak Tahfidhul Qur`an, No. Rekening 5936-01-005247-53-0, Bank BRI (kode bank 002), dan selanjutnya mohon dilaporkan bukti transfernya melalui alamat url: payment.ppatq-rf.id

// Demikian beberapa yang perlu kami sampaikan, mohon maaf, apabila walisantri telah melakukan pembayaran / pelaporan, dimohon diabaikan pesan ini.

// Wassalâmu`alaikum warohmatulloh 


// Mengetahui
// Khodimul Ma`had
// K. Noor Shokhib M.Pd.I

// *Pesan ini otomatis dikirim dari sistem manajemen laporan pembayaran*
// ';  
$pesan = '
Assalamualaikum Wr Wb,
Yth Wali Santri ' . $row->nama . ' (' . $row->kelas . ')

Mohon maaf atas ketidaknyaman informasi ini. Kami sampaikan bahwa sampai dengan saat ini pada payment.ppatq-rf.id (sistem pelaporan pencatatan pembayaran syahriah), belum ada catatan/bukti pembayaran untuk bulan Desember 2023 untuk santri a/n ' . $row->nama . '

Untuk itu, bagi yang belum melakukan pembayaran, kami memohon untuk segera melakukan pembayaran (transfer ke Rek.PPATQ-RF BRI : 5936-01-005247-53-0, kode bank : 002) dan selanjutnya mohon melakukan pelaporan hasil transfer melalui payment.ppatq-rf.id
mengingat pembagian uang saku dilakukan sebelum tanggal 20 setiap bulannya.

Bagi yang sudah melakukan pembayaran/transfer dan pelaporan di payment.ppatq-rf.id kami ucapkan terimakasih sebanyak-banyaknya.

Terimakasih perhatian dan mohon maaf jika ada hal yang kurang berkenan

Wassalamualaikum Wr Wb';
			$hasil = $this->send_wa_to_tbl($row->atas_nama,$row->no_hp,$pesan);
			if($hasil){
				//kirim dengan menggunakn wa api; 085726553442 no asli
				$data['no_wa'] = $row->no_hp;
				$data['pesan'] = $pesan;
				//$data['url'] = "https://payment.ppatq-rf.id/assets/images/pengumuman.jpeg";
				$send_wa = $this->wa->send_wa($data);
			}
		}
		redirect(base_url('index.php/admin/pembayaran/belum_lapor'));
	}
	public function kirim_pengumuman(){
		$mahasiswa = $this->db->get('tb_siswa_detail')->result();
		$i = 1;
// 		$pesan = "Kepada segenap wali santri PPATQ-RF

// *Assalâmu`alaikum warohamatulloh*

// Kami atas nama pengurus, bendahara dan diketahui Pengasuh PPATQ-RF memberitahukan kembali, PERATURAN terkait kewajiban *Syahriyah dan Saku bulanan santri*  bahwa : 

// 1. Wajib membayarkan syahriah dan saku tepat waktu, yaitu *SEBELUM TANGGAL 10 SETIAP BULAN nya*

// 2. Bagi yang melebihi pembayaran di atas tanggal 10, saku ditangguhkan (khusus yang tak mempunyai saldo) 

// 3. Pondok PPATQ-RF menyelenggarakan acara kirim Arwahan, sekiranya ada walisantri yang berkeingian berperan serta, dapat melakuan transfer dan selanjutnya dilaporkan bukti transfernya dapat melalui payment.ppatq-rf.id, Kegiatan / acara Arwahan ini hanya bulan september ini, *terakhir tanggal 22 Sept 2023*

// 4. Silakan membayar dengan mode transfer pada rekening yang telah ditentukan, dan selanjutnya mohon dilaporkan bukti transfernya melalui alamat url: payment.ppatq-rf.id

// Demikian beberapa yang perlu kami sampaikan, mohon maaf, apabila walisantri telah melakukan pembayaran / pelaporan, dimohon diabaikan pesan ini.

// Wassalâmu`alaikum warohmatulloh 



// Mengetahui
// _Khodimul Ma`had_
// K. Noor Shokhib M.Pd.I";
		$pesan = "Kepada segenap wali santri PPATQ-RF

Assalâmu`alaikum warohamatullohiwabarokatuh

Berdasarkan edaran yang telah dipublikasikan yaitu 
Sambangan bulan November dilaksanakan pada hari Sabtu-Ahad, 11 – 12 Nopember 2023
(mulai Sabtu malam Ahad pukul 20.15 sampai Ahad sore pukul 16:00)

Maka kami atas nama pengurus, bendahara dan diketahui Pengasuh PPATQ-RF mengingatkan kembali, 
PERATURAN terkait *kewajiban Syahriyah, Tunggakan, Daftar Ulang & Uang Saku bulanan*  untuk bulan NOVEMBER 2023.

Dan juga *PPATQ RF* sedang *membangun tempat halaqoh tahfidz Putra* di lantai dua (atas dapur dan loundry) untuk itu bagi yang berlebih dalam keuangan bisa berinfaq untuk kelanjutan pembangunan tersebut. 
untuk itu :  

1. Wajib membayarkan syahriah dan saku tepat waktu, yaitu *SEBELUM TANGGAL 10 SETIAP BULAN-nya*

2. Pelayanan Administrasi bulanan pada saat sambangan *tidak menerima TUNAI* dan juga  *diTUTUP* dan dialihkan menggunakan aplikasi dengan klik / akses  http://payment.ppatq-rf.id dengan melakukan pembayaran dengan metode transfer ke Bank BRI dengan No.Rekening *5936-01-005247-53-0* 
a/n *Pondok Anak Tahfidhul Qur’an Unit/Cabang BRI Gembong* , dan selanjutnya *WAJIB* dilaporkan bukti transfernya melalui url  http://payment.ppatq-rf.id

3. Apabila berkeinginan infaq pembangunan holaqoh, silakan transfer dan mohon dilaporankan dengan memilih kolom *sumbangan pembangunan* pada sistem pelaporan  http://payment.ppatq-rf.id

Catatan, 
Pemberitahuan ini bagian dari upaya menyampaikan bahwa ketepatan membayar menjadi penting untuk kegiatan rutin dilingkungan PPATQ-RF.
Demikian beberapa yang perlu kami sampaikan, mohon maaf, apabila walisantri telah melakukan pembayaran / pelaporan, dimohon diabaikan pesan ini.

Tak lupa, kami mengucapkan banyak terima kasih yang sebesar-besarnya.

Wassalâmu`alaikum warohmatullahiwabarokatuh

Mengetahui
Khodimul Ma`had
K. Noor Shokhib M.Pd.I



Pesan ini otomatis dikirim dari sistem manajemen laporan pembayaran";
		$array_tambahan_nomor = array(
			'pak muslim PPATQ RF' => '089601087437',
			'Ust Shokhib' => '089668309013',
			'Ustadz Muhadi PPATQ' => '08979194645'
		);
		foreach($array_tambahan_nomor as $key=>$value){
			$data['no_wa'] = $value;
			$data['pesan'] = $pesan;
			$data['url'] = "https://payment.ppatq-rf.id/assets/images/pengumuman.jpeg";
			$send_wa = $this->wa->send_wa_img($data);
		}
		foreach($mahasiswa as $row){
			$no_hp = str_replace(" ","",$row->no_hp);
			echo $i . ". Santri : " . $row->nama . " - " . trim($no_hp);
			echo "<br />";
			
			
			if(!empty($no_hp)){
				$hasil = $this->send_wa_to_tbl($row->nama,$no_hp,$pesan);
				if($hasil){
					//kirim dengan menggunakn wa api; 085726553442 no asli
					$data['no_wa'] = $no_hp;
					$data['pesan'] = $pesan;
					$data['url'] = "https://payment.ppatq-rf.id/assets/images/pengumuman.jpeg";
					$send_wa = $this->wa->send_wa_img($data);
				}
			}
			$i++;
		}

		
		//$data['no_wa'] = "082326248982";
		echo "berhasil";
		
	}	
}
