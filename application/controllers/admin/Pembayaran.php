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
        foreach($siswa as $row){
            $data['siswa'][$row->no_induk] = $row->nama;
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
            $data['siswa'] = $this->siswa->get_all();
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
                // echo $row->id;
                // echo "<br />";
                foreach($detailPembayaran as $detail){
                    $santri[$row->nama_santri][$detail->id_jenis_pembayaran] += $detail->nominal;
                }
            }
            // var_dump($santri[5]);
            // exit;

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
		$nama_santri = $this->db->where(['id'=>$id_santri])->get("ref_siswa")->row()->nama;
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
			
			$wa = $this->wa->validasi($id,$validasi);
			
			
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
		$get_pembayaran_tunggakan = $this->db->where('id_pembayaran',$id)->get('tb_pembayaran_tunggakan')->num_rows();
		
        $wa = $this->wa->validasi($id,$new_validasi);
        
		if($get_pembayaran_tunggakan > 0){
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
		//echo $validasi . " " . $new_validasi;
		$convert_wa = json_decode($wa);
        if($update){
            $this->session->set_flashdata('message','data berhasil diupdate ' . $wa);
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
		
		$this->load->library('pdfgenerator');
		$this->data['title_pdf'] = 'Tagihan Santri';
        
        // filename dari pdf ketika didownload
        $file_pdf = 'bukti_pembayaran_santri';
        // setting paper
        $paper = 'A6';
        //orientasi paper potrait / landscape
        $orientation = "portrait";
        
		$html = $this->load->view('admin/pembayaran/print',$data, true);	    
        
        // run dompdf
        $this->pdfgenerator->generate($html, $file_pdf, $paper,$orientation);
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
		$data['nama_santri'] = $this->siswa->get_by_id($data['pembayaran']->nama_santri);
		$data['bulan'] = $this->bulan;
		$jenis = $this->jenis->get_all();
		$data['jenis_pembayaran'] = array();
		foreach($jenis as $row){
			$data['jenis_pembayaran'][$row->id] = $row->jenis;
		}
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
		foreach($no_hp as $row){
			$pesan = '
*Pesan ini otomatis dikirim dari sistem manajemen laporan pembayaran*

Assalamualaikum,

Mohon maaf, 
Pada sistem report payment kami, belum ada catatan untuk pembayaran bulan ' . $this->bulan[(int)date('m')] . ', mohon maaf, bila ada kekeliruan/kesalahan report. 
Jika belum melakukan pembayaran, harap segera melakukan pembayaran, selanjutnya dapat melakukan report melalui payment.ppatq-rf.id
Jika telah melakukan pembayaran dan belum melakukan report, silakan segera melakukan report melalui payment.ppatq-rf.id

karena reporting sangat penting buat lembaga ppatqrf untuk pencatatan serta distribusi sesuai keperuntukannya.

terimakasih atas perhatian dan mohon maaf jika ada hal yang kurang berkenan.

Wassalamualaikum
'; 
			$hasil = $this->send_wa_to_tbl($row->atas_nama,$row->no_hp,$pesan);
			if($hasil){
				//kirim dengan menggunakn wa api; 085726553442 no asli
				$data['no_wa'] = $row->no_hp;
				$data['pesan'] = $pesan;
				$send_wa = $this->wa->send_wa($data);
			}
		}
		redirect(base_url('index.php/admin/pembayaran/belum_lapor'));
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
		$no_hp = $this->db->select('ref_no_hp.*,tb_siswa_detail.nama')->join('tb_siswa_detail','tb_siswa_detail.no_induk = ref_no_hp.no_induk')->group_by('ref_no_hp.no_induk')->where_not_in('ref_no_hp.no_induk',$no_induk)->get('ref_no_hp')->result();
		foreach($no_hp as $row){
			$pesan = '
*Pesan ini otomatis dikirim dari sistem manajemen laporan pembayaran*

Assalamualaikum,

Mohon maaf, 
Pada sistem report payment kami, belum ada catatan untuk pembayaran bulan ' . $this->bulan[(int)$bulan] . ', mohon maaf, bila ada kekeliruan/kesalahan report. 
Jika belum melakukan pembayaran, harap segera melakukan pembayaran, selanjutnya dapat melakukan report melalui payment.ppatq-rf.id
Jika telah melakukan pembayaran dan belum melakukan report, silakan segera melakukan report melalui payment.ppatq-rf.id

karena reporting sangat penting buat lembaga ppatqrf untuk pencatatan serta distribusi sesuai keperuntukannya.

terimakasih atas perhatian dan mohon maaf jika ada hal yang kurang berkenan.

Wassalamualaikum
'; 
$pesan2 = 'ralat URL (kesalahan ketik)
yang benar adalah:  payment.ppatq-rf.id

mohon maaf';
			$hasil = $this->send_wa_to_tbl($row->atas_nama,$row->no_hp,$pesan2);
			if($hasil){
				//kirim dengan menggunakn wa api; 085726553442 no asli
				$data['no_wa'] = $row->no_hp;
				$data['pesan'] = $pesan;
				$send_wa = $this->wa->send_wa($data);
			}
		}
		redirect(base_url('index.php/admin/pembayaran/belum_lapor'));
	}
	public function kirim_pengumuman(){
		$mahasiswa = $this->db->get('tb_siswa_detail')->result();
		$i = 1;
		$pesan = "Kepada segenap wali santri PPATQ-RF

*Assalâmu`alaikum warohamatulloh*

Kami atas nama pengurus, bendahara dan diketahui Pengasuh PPATQ-RF memberitahukan kembali, PERATURAN terkait kewajiban *Syahriyah dan Saku bulanan santri*  bahwa : 

1. Wajib membayarkan syahriah dan saku tepat waktu, yaitu *SEBELUM TANGGAL 10 SETIAP BULAN nya*

2. Bagi yang melebihi pembayaran di atas tanggal 10, saku ditangguhkan (khusus yang tak mempunyai saldo) 

3. Pondok PPATQ-RF menyelenggarakan acara kirim Arwahan, sekiranya ada walisantri yang berkeingian berperan serta, dapat melakuan transfer dan selanjutnya dilaporkan bukti transfernya dapat melalui payment.ppatq-rf.id, Kegiatan / acara Arwahan ini hanya bulan september ini, *terakhir tanggal 22 Sept 2023*

4. Silakan membayar dengan mode transfer pada rekening yang telah ditentukan, dan selanjutnya mohon dilaporkan bukti transfernya melalui alamat url: payment.ppatq-rf.id

Demikian beberapa yang perlu kami sampaikan, mohon maaf, apabila walisantri telah melakukan pembayaran / pelaporan, dimohon diabaikan pesan ini.

Wassalâmu`alaikum warohmatulloh 



Mengetahui
_Khodimul Ma`had_
K. Noor Shokhib M.Pd.I";
		foreach($mahasiswa as $row){
			$no_hp = str_replace(" ","",$row->no_hp);
			echo $i . ". Santri : " . $row->nama . " - " . trim($no_hp);
			echo "<br />";
			
			if($i > 263){
				if(!empty($no_hp)){
					$hasil = $this->send_wa_to_tbl($row->nama,$no_hp,$pesan);
					if($hasil){
						//kirim dengan menggunakn wa api; 085726553442 no asli
						$data['no_wa'] = $no_hp;
						$data['pesan'] = $pesan;
						$send_wa = $this->wa->send_wa($data);
					}
				}
			}
			$i++;
		}
		
	}	
}
