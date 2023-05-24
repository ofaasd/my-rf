<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {

    public function __construct(){
        parent::__construct();
        if(empty($this->session->userdata('roles'))){
            redirect(base_url('index.php/auth/login'));
        }else{
            if($this->session->userdata('roles') != 'Admin'){
                redirect(base_url('index.php/auth/login'));
            }
        }
        $this->load->model('Kategori_model','kategori');
    }

    public function index(){
		
        $data['kategori'] = $this->kategori->get_all();

		$var['title'] = 'Kategori';
		$var['content'] = $this->load->view('admin/kategori/index',$data,true);

		$this->load->view('layouts/admin',$var);
    }

    public function create(){

        $data['kategori'] = '';

		$var['title'] = 'Tambah Kategori';
		$var['content'] = $this->load->view('admin/kategori/create',$data,true);

		$this->load->view('layouts/admin',$var);
    }

    
    public function edit($id){

        $data['kategori'] = $this->kategori->get_by_id($id);

		$var['title'] = 'Edit Kategori';
		$var['content'] = $this->load->view('admin/kategori/create',$data,true);

		$this->load->view('layouts/admin',$var);
    }

    public function insert(){
        $insert = $this->kategori->insert();
        if($insert){
            $this->session->set_flashdata('message','data berhasil ditambahkan');
            redirect(base_url('index.php/admin/kategori'));
        }else{
            redirect(base_url('index.php/admin/kategori/create'));
        }
    }

    public function update(){
        $update = $this->kategori->update();
        if($update){
            $this->session->set_flashdata('message','data berhasil diupdate');
            redirect(base_url('index.php/admin/kategori'));
        }else{
            redirect(base_url('index.php/admin/kategori/edit/' . $id));
        }
    }

    public function delete($id){
        $delete = $this->kategori->delete($id);
        if($delete){
            $this->session->set_flashdata('message','data berhasil dihapus');
            redirect(base_url('index.php/admin/kategori'));
        }else{
            redirect(base_url('index.php/admin/kategori/'));
        }
    }



}