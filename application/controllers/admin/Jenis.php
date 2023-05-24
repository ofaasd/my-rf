<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis extends CI_Controller {

    public function __construct(){
        parent::__construct();
        if(empty($this->session->userdata('roles'))){
            redirect(base_url('index.php/auth/login'));
        }else{
            if($this->session->userdata('roles') != 'Admin'){
                redirect(base_url('index.php/auth/login'));
            }
        }
        $this->load->model('Jenis_model','jenis');
    }

    public function index(){
		
        $data['jenis'] = $this->jenis->get_all();

		$var['title'] = 'Jenis Pembayaran';
		$var['content'] = $this->load->view('admin/jenis/index',$data,true);

		$this->load->view('layouts/admin',$var);
    }

    public function create(){

        $data['jenis'] = '';

		$var['title'] = 'Tambah Jenis Pembayaran';
		$var['content'] = $this->load->view('admin/jenis/create',$data,true);

		$this->load->view('layouts/admin',$var);
    }

    
    public function edit($id){

        $data['jenis'] = $this->jenis->get_by_id($id);

		$var['title'] = 'Edit Jenis Pembayaran';
		$var['content'] = $this->load->view('admin/jenis/create',$data,true);

		$this->load->view('layouts/admin',$var);
    }

    public function insert(){
        $insert = $this->jenis->insert();
        if($insert){
            $this->session->set_flashdata('message','data berhasil ditambahkan');
            redirect(base_url('index.php/admin/jenis'));
        }else{
            redirect(base_url('index.php/admin/jenis/create'));
        }
    }

    public function update(){
        $update = $this->jenis->update();
        if($update){
            $this->session->set_flashdata('message','data berhasil diupdate');
            redirect(base_url('index.php/admin/jenis'));
        }else{
            redirect(base_url('index.php/admin/jenis/edit/' . $id));
        }
    }

    public function delete($id){
        $delete = $this->jenis->delete($id);
        if($delete){
            $this->session->set_flashdata('message','data berhasil dihapus');
            redirect(base_url('index.php/admin/jenis'));
        }else{
            redirect(base_url('index.php/admin/jenis/'));
        }
    }



}