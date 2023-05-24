<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct(){
        parent::__construct();
        if(empty($this->session->userdata('roles'))){
            redirect(base_url('index.php/auth/login'));
        }else{
            if($this->session->userdata('roles') != 'Admin'){
                redirect(base_url('index.php/auth/login'));
            }
        }
    }

    public function index(){
		
		$data['siswa'] = $this->db->get("ref_siswa")->num_rows();
		$data['keluhan'] = $this->db->where('is_hapus',0)->get("tb_keluhan")->num_rows();
		$data['cash'] = $this->db->where('is_hapus',0)->where("tipe","Cash")->get("tb_pembayaran")->num_rows();
		$data['bank'] = $this->db->where('is_hapus',0)->where("tipe","Bank")->get("tb_pembayaran")->num_rows();
		$data['bulan'] = array(1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
		

		$var['title'] = 'PPATQ Roudlotul Falah Admin Page';
		$var['content'] = $this->load->view('admin/dashboard/index',$data,true);

		$this->load->view('layouts/admin',$var);
    }
	public function jumlah_keluhan(){
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		
		$keluhan = $this->db->where('MONTH(created_at)',$bulan )->where('YEAR(created_at)',$tahun )->where('is_hapus',0)->get('tb_keluhan')->result();
		$data['jumlah_keluhan'] = array();
		$data['tanggal'] = "";
		foreach($keluhan as $row){
			$tanggal = date('Y-m-d', strtotime($row->created_at));
			$data['tanggal'] .= $tanggal . ",";
			if(empty($jumlah_keluhan[$tanggal])){
				$data['jumlah_keluhan'][$tanggal] = 1;
			}else{
				$data['jumlah_keluhan'][$tanggal] += 1;
			}
		}
		return $this->load->view('admin/dashboard/jumlah_keluhan',$data);
		
	}
}