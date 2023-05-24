<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keringanan extends CI_Controller {

    public function __construct(){
        parent::__construct();
        if(empty($this->session->userdata('roles'))){
            redirect(base_url('index.php/auth/login'));
        }else{
            if($this->session->userdata('roles') != 'Admin'){
                redirect(base_url('index.php/auth/login'));
            }
        }
        $this->load->model('Keringanan_model','keringanan');
        $this->load->model('Siswa_model','siswa');
        $this->load->model('Jenis_model','jenis');
    }

    public function index(){
		
        $data['keringanan'] = $this->keringanan->get_all();

		$var['title'] = 'Daftar Keringanan Siswa';
		$var['content'] = $this->load->view('admin/keringanan/index',$data,true);

		$this->load->view('layouts/admin',$var);
    }

    public function create(){

        $data['siswa'] = $this->siswa->get_all();
		$data['jenis'] = $this->jenis->get_all();

		$var['title'] = 'Tambah Keringanan Siswa';
		$var['content'] = $this->load->view('admin/keringanan/create',$data,true);

		$this->load->view('layouts/admin',$var);
    }

    
    public function edit($id){

        $data['keringanan'] = $this->keringanan->get_by_id($id);
		$data['siswa'] = $this->siswa->get_all();
		$data['jenis'] = $this->jenis->get_all();

		$var['title'] = 'Edit Keringanan Siswa';
		$var['content'] = $this->load->view('admin/keringanan/create',$data,true);

		$this->load->view('layouts/admin',$var);
    }

    public function insert(){
        $insert = $this->keringanan->insert();
        if($insert){
            $this->session->set_flashdata('message','data berhasil ditambahkan');
            redirect(base_url('index.php/admin/keringanan'));
        }else{
            redirect(base_url('index.php/admin/keringanan/create'));
        }
    }

    public function update(){
        $update = $this->keringanan->update();
        if($update){
            $this->session->set_flashdata('message','data berhasil diupdate');
            redirect(base_url('index.php/admin/keringanan'));
        }else{
            redirect(base_url('index.php/admin/keringanan/edit/' . $id));
        }
    }

    public function delete($id){
        $delete = $this->keringanan->delete($id);
        if($delete){
            $this->session->set_flashdata('message','data berhasil dihapus');
            redirect(base_url('index.php/admin/keringanan'));
        }else{
            redirect(base_url('index.php/admin/keringanan/'));
        }
    }
}