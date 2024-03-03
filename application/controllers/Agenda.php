<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda extends CI_Controller {
    
    public function __construct(){
        parent::__construct();

        $this->load->model('Kategori_model','kategori');
        $this->load->model('Keluhan_model','keluhan');
        $this->load->model('Siswa_model','siswa');
        $this->load->model('Guru_model','guru');

    }

	public function index()
	{
		$tanggal = date('Y-m-d H:i:s');
		$data['agenda_sekarang'] = $this->db->where('tanggal_mulai <= ', $tanggal)->where('tanggal_selesai >= ', $tanggal)->where('deleted_at IS NULL', NULL, FALSE)->get('agenda')->result();
		$data['agenda_akan_datang'] = $this->db->where('tanggal_mulai > ', $tanggal)->where('deleted_at IS NULL', NULL, FALSE)->get('agenda')->result();
		$data['agenda_lalu'] = $this->db->where('tanggal_selesai < ', $tanggal)->where('deleted_at IS NULL', NULL, FALSE)->get('agenda')->result();
		//exit;
		$var['title'] = 'PPATQ Roudlotul Falah';
		$var['content'] = $this->load->view('agenda/index',$data,true);

		$this->load->view('layouts/main',$var);
	}
}
