<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bukatutup extends CI_Controller {

    public function __construct(){
        parent::__construct();
        if(empty($this->session->userdata('roles'))){
            redirect(base_url('index.php/auth/login'));
        }else{
            if($this->session->userdata('roles') != 'Admin'){
                redirect(base_url('index.php/auth/login'));
            }
        }
        $this->load->model('Bukatutup_model','bukatutup');
    }

    public function index(){
		
        $data['bukatutup'] = $this->bukatutup->get_bukatutup();

		$var['title'] = 'Buka Tutup Laporan Pembayaran';
		$var['content'] = $this->load->view('admin/bukatutup/index',$data,true);

		$this->load->view('layouts/admin',$var);
    }

    public function create(){

        $data['bukatutup'] = '';

		$var['title'] = 'Tambah bukatutup';
		$var['content'] = $this->load->view('admin/bukatutup/create',$data,true);

		$this->load->view('layouts/admin',$var);
    }

    
    public function edit($id){

        $data['bukatutup'] = $this->bukatutup->get_by_id($id);

		$var['title'] = 'Edit bukatutup';
		$var['content'] = $this->load->view('admin/bukatutup/create',$data,true);

		$this->load->view('layouts/admin',$var);
    }

    public function insert(){
        $insert = $this->bukatutup->insert();
        if($insert){
            $this->session->set_flashdata('message','data berhasil diubah');
            redirect(base_url('index.php/admin/bukatutup'));
        }else{
            redirect(base_url('index.php/admin/bukatutup'));
        }
    }

    public function update(){
        $update = $this->bukatutup->update();
        if($update){
            $this->session->set_flashdata('message','data berhasil diupdate');
            redirect(base_url('index.php/admin/bukatutup'));
        }else{
            redirect(base_url('index.php/admin/bukatutup/edit/' . $id));
        }
    }

    public function delete($id){
        $delete = $this->bukatutup->delete($id);
        if($delete){
            $this->session->set_flashdata('message','data berhasil dihapus');
            redirect(base_url('index.php/admin/bukatutup'));
        }else{
            redirect(base_url('index.php/admin/bukatutup/'));
        }
    }



}