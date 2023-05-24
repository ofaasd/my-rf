<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tunggakan extends CI_Controller {
	
	public $bulan = array(1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');

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
        $this->load->model('Keringanan_model','keringanan');
		$this->load->model('Tunggakan_model','tunggakan');
		$this->load->model('Jenis_model','jenis');
		$this->load->model('Siswa_model','siswa');
		$this->load->model('Keringanan_model','keringanan');
    }

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
		
        $data['tunggakan'] = $this->tunggakan->get_by_bulan($bulan,$tahun);
		
		$jenis = $this->jenis->get_all();
		$data['jenis'] = array();
		foreach($jenis as $row){
			$data['jenis'][$row->id] = $row->jenis;
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
		$data['bulan'] = $this->bulan;
		
		$var['title'] = 'Tunggakan';
		$var['content'] = $this->load->view('admin/tunggakan/index',$data,true);

		$this->load->view('layouts/admin',$var);
    }
	
    public function create(){
		$curr_bulan = date('m');
		$curr_tahun = date('Y');
		$data['bulan'] = $this->bulan;
		$data['curr_bulan'] = $curr_bulan;
		$data['jenis'] = $this->jenis->get_all();
        $data['pembayaran'] = $this->pembayaran->get_by_periode($curr_bulan,$curr_tahun);
		$data['jenis_pembayaran'] = $this->jenis->get_cat_tunggakan();
		$data['siswa'] = $this->siswa->get_all();
		
		$santri = array();
		$tagihan = array();
		foreach($data['siswa'] as $siswa){
			foreach($data['jenis_pembayaran'] as $jenis_pembayaran){
				$santri[$siswa->id][$jenis_pembayaran->id] = 0;
				$tagihan[$siswa->id][$jenis_pembayaran->id] = $jenis_pembayaran->harga;
			}
		}
		
		//ubah data bagi siswa yang mendapat keringanan
		$keringanan = $this->keringanan->get_all2();
		foreach($keringanan as $row){
			$tagihan[$row->id_siswa][$row->id_jenis_pembayaran] = $row->harga;
		}
		
		$data['tagihan'] = $tagihan;
		
		//assign nilai di dalamnya
		foreach($data['pembayaran'] as $row){
			$detailPembayaran = $this->detail->get_by_id_pembayaran_tunggakan($row->id);
			// echo $row->id;
			// echo "<br />";
			foreach($detailPembayaran as $detail){
				$santri[$row->nama_santri][$detail->id_jenis_pembayaran] += $detail->nominal;
			}
		}
		$data['list_bayar'] = $santri;
		
		

		$var['title'] = 'Tambah tunggakan';
		$var['content'] = $this->load->view('admin/tunggakan/edit',$data,true);

		$this->load->view('layouts/admin',$var);
    }

    
    public function edit($id){

		$curr_bulan = date('m');
		$curr_tahun = date('Y');
		$data['bulan'] = $this->bulan;
		$data['curr_bulan'] = $curr_bulan;
		$data['jenis'] = $this->jenis->get_all();
		$data['siswa'] = $this->siswa->get_all();
		
        $data['tunggakan'] = $this->tunggakan->get_by_id($id);

		$var['title'] = 'Edit tunggakan';
		$var['content'] = $this->load->view('admin/tunggakan/edit',$data,true);

		$this->load->view('layouts/admin',$var);
    }

    public function insert(){
		$id_siswa = $this->input->post('id_siswa');
		$id_jenis = $this->input->post('id_jenis');
		//max_input_vars harus di naikan dari php ini 
		/* echo count($id_siswa);
		echo "<br />" . count($id_jenis);
		var_dump($id_siswa);
		var_dump($id_jenis);
		exit; */
        $insert = $this->tunggakan->insert();
		
        if($insert){
            $this->session->set_flashdata('message','data berhasil ditambahkan');
            redirect(base_url('index.php/admin/tunggakan'));
        }else{
            redirect(base_url('index.php/admin/tunggakan/create'));
        }
    }
	public function insert2(){
		
        $insert = $this->tunggakan->insert2();
		
        if($insert){
            $this->session->set_flashdata('message','data berhasil ditambahkan');
            redirect(base_url('index.php/admin/tunggakan'));
        }else{
            redirect(base_url('index.php/admin/tunggakan/create'));
        }
    }

    public function update(){
		$id = $this->input->post('id');
        $update = $this->tunggakan->update();
        if($update){
            $this->session->set_flashdata('message','data berhasil diupdate');
            redirect(base_url('index.php/admin/tunggakan'));
        }else{
            redirect(base_url('index.php/admin/tunggakan/edit/' . $id));
        }
    }

    public function delete($id){
        $delete = $this->tunggakan->delete($id);
        if($delete){
            $this->session->set_flashdata('message','data berhasil dihapus');
            redirect(base_url('index.php/admin/tunggakan'));
        }else{
            redirect(base_url('index.php/admin/tunggakan/'));
        }
    }

}