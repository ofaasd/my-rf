<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class infografis extends CI_Controller {
    
    public function __construct(){
        parent::__construct();

        $this->load->model('Kategori_model','kategori');
        $this->load->model('Keluhan_model','keluhan');
        $this->load->model('Siswa_model','siswa');
        $this->load->model('Guru_model','guru');

    }

	public function index()
	{
		$jenis_kelamin = array('Laki-laki','Perempuan');
		$get_jabatan = $this->guru->get_jabatan();
		//update jabatan to jabatan new
		//SELECT * FROM `tb_guru` WHERE jabatan like '%murobby%'
		$data['jenis'] = array();
		$data['siswa'] = array();
		foreach($jenis_kelamin as $jk){
			foreach($get_jabatan as $row){
				$data['jenis'][$jk][$row->jabatan_new]  = $this->guru->count_by_jenis($row->jabatan_new,$jk);
				// echo $row->jabatan_new . " " . $jk . " ";
				// echo $this->guru->count_by_jenis($row->jabatan_new,$jk);
				// echo "<br />";
			}
		}
		$data['jabatan'] = $get_jabatan;
		$data['jenis_kelamin'] = $jenis_kelamin;
		//exit;
		$var['title'] = 'PPATQ Roudlotul Falah';
		$var['content'] = $this->load->view('infografis/index',$data,true);

		$this->load->view('layouts/main',$var);
	}
}
