<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Whatsapp extends CI_Controller {

    public function __construct(){
        parent::__construct();
        if(empty($this->session->userdata('roles'))){
            redirect(base_url('index.php/auth/login'));
        }else{
            if($this->session->userdata('roles') != 'Admin'){
                redirect(base_url('index.php/auth/login'));
            }
        }
        $this->load->model('Wa_model','wa');
    }

    public function index(){
		
        $data['wa'] = $this->wa->get_all();

		$var['title'] = 'Log Whatsapp';
		$var['content'] = $this->load->view('admin/wa/index',$data,true);

		$this->load->view('layouts/admin',$var);
    }

    public function create(){

        $data['whatsapp'] = '';

		$var['title'] = 'Tambah Pesan Whatsapp Baru';
		$var['content'] = $this->load->view('admin/wa/create',$data,true    );

		$this->load->view('layouts/admin',$var);
    }

    
    public function edit($id){

        $data['wa'] = $this->wa->get_by_id($id);

		$var['title'] = 'Edit whatsapp';
		$var['content'] = $this->load->view('admin/wa/create',$data,true);

		$this->load->view('layouts/admin',$var);
    }

    public function insert(){
        $insert = $this->wa->insert();
        $data = array(
            'no_wa' => $this->input->post('no_wa'),
            'pesan' => $this->input->post('pesan'),
        );
        $send = $this->wa->send_wa($data);
        $decode = json_decode($send);
        $msg = "";
        if($decode->status != 200){
            $msg = "pesan gagal dikirimkan";
        }else{
            $msg = "pesan berhasil dikirimkan";
        }
        if($insert){
            $this->session->set_flashdata('message','data berhasil ditambahkan dan ' . $msg);
            redirect(base_url('index.php/admin/whatsapp'));
        }else{
            redirect(base_url('index.php/admin/whatsapp/create'));
        }
    }

    public function update(){
        $update = $this->wa->update();
        if($update){
            $this->session->set_flashdata('message','data berhasil diupdate');
            redirect(base_url('index.php/admin/whatsapp'));
        }else{
            redirect(base_url('index.php/admin/whatsapp/edit/' . $id));
        }
    }
    public function resend($id){
        $wa = $this->wa->get_by_id($id);
        $data = array(
            'no_wa' => $wa->no_wa,
            'pesan' => $wa->pesan,
        );
        $send = $this->wa->send_wa($data);
        $decode = json_decode($send);
        $msg = "";
        if($decode->status != 200){
            $this->session->set_flashdata('error','pesan gagal dikirimkan ' . $send);
            redirect(base_url('index.php/admin/whatsapp'));
        }else{
            $this->session->set_flashdata('message','Pesan berhasil dikirimkan');
            redirect(base_url('index.php/admin/whatsapp'));
        }
    }

    public function delete($id){
        $delete = $this->wa->delete($id);
        if($delete){
            $this->session->set_flashdata('message','data berhasil dihapus');
            redirect(base_url('index.php/admin/whatsapp'));
        }else{
            redirect(base_url('index.php/admin/whatsapp/'));
        }
    }



}