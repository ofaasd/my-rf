<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keluhan extends CI_Controller {
    
    public function __construct(){
        parent::__construct();

        $this->load->model('Kategori_model','kategori');
        $this->load->model('Keluhan_model','keluhan');
        $this->load->model('Siswa_model','siswa');

    }

	public function index()
	{
		$data['kategori'] = $this->kategori->get_all();
		$data['siswa'] = $this->siswa->get_all();
		$data['kode'] = $this->siswa->get_kelas_all();
		
		$var['title'] = 'PPATQ Roudlotul Falah';
		$var['content'] = $this->load->view('keluhan/index',$data,true);

		$this->load->view('layouts/main',$var);
	}
    public function insert(){
        $verifikasi = $this->siswa->verifikasi_siswa();
        if($verifikasi){
            $insert = $this->keluhan->insert();
            if($insert){
                $this->session->set_flashdata('message','data berhasil disimpan');
                redirect(base_url('/index.php/keluhan'));
            }else{
                redirect(base_url('/'));
            }
        }else{
            $this->session->set_flashdata('error','Nama Santri dengan kode tidak cocok');
            redirect(base_url('/'));
        }
    }
}
