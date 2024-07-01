<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Carbon\Carbon;

class Welcome extends CI_Controller {
	public function __construct(){
        parent::__construct();

		$this->load->model('Berita_model','berita');

    }

	public function index()
	{
		// $this->load->model('Kategori_model','kategori');
		// $this->load->model('Siswa_model','siswa');

		// $data['kategori'] = $this->kategori->get_all();
		// $data['siswa'] = $this->siswa->get_all();
		// $data['kode'] = $this->siswa->get_kelas_all();
		
		$data['berita'] = $this->berita->get_latest();
		$var['title'] = 'PPATQ Roudlotul Falah';
		$var['content'] = $this->load->view('welcome/index',$data,true);

		$this->load->view('layouts/main',$var);
	}
}
