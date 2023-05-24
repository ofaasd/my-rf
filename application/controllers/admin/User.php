<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct(){
        parent::__construct();
        if(empty($this->session->userdata('roles'))){
            redirect(base_url('index.php/auth/login'));
        }else{
            if($this->session->userdata('roles') != 'Admin'){
                redirect(base_url('index.php/auth/login'));
            }
        }
        $this->load->model('User_model','user');
		$this->load->library('form_validation');
    }

    public function index(){
		
        $data['user'] = $this->user->get_all();

		$var['title'] = 'Daftar Pengguna';
		$var['content'] = $this->load->view('admin/user/index',$data,true);

		$this->load->view('layouts/admin',$var);
    }

    public function create(){

        $data['user'] = '';

		$var['title'] = 'Tambah Pengguna';
		$var['content'] = $this->load->view('admin/user/create',$data,true);

		$this->load->view('layouts/admin',$var);
    }

    
    public function edit($id){

        $data['user'] = $this->user->get_by_id($id);

		$var['title'] = 'Edit Pengguna';
		$var['content'] = $this->load->view('admin/user/create',$data,true);

		$this->load->view('layouts/admin',$var);
    }
	public function edit_password($id){

        $data['user'] = $this->user->get_by_id($id);

		$var['title'] = 'Edit Password Pengguna';
		$var['content'] = $this->load->view('admin/user/edit_password',$data,true);

		$this->load->view('layouts/admin',$var);
    }

    public function insert(){
		$this->form_validation->set_rules('name', 'name', 'required');
        $this->form_validation->set_rules('username', 'Username', 'callback_username_check');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        $this->form_validation->set_rules('email', 'Email', 'callback_email_check');
        if ($this->form_validation->run() == FALSE)
        {
            $data['user'] = '';

			$var['title'] = 'Tambah Pengguna';
			$var['content'] = $this->load->view('admin/user/create',$data,true);

			$this->load->view('layouts/admin',$var);
        }
        else
        {
            $register = $this->user->register_admin();
            if($register){
                $this->session->set_flashdata('message','Pendaftaran Berhasil Silahkan Login Kembali');
                redirect(base_url('/index.php/admin/user/index'));
            }else{
                $this->session->set_flashdata('message','Data Gagal di input');
                redirect(base_url('/index.php/admin/user/create'));
            }
        }
    }

    public function update(){
        $update = $this->user->update();
        if($update){
            $this->session->set_flashdata('message','data berhasil diupdate');
            redirect(base_url('index.php/admin/user'));
        }else{
            redirect(base_url('index.php/admin/user/edit/' . $id));
        }
    }public function update_password(){
        $update = $this->user->update_password();
        if($update){
            $this->session->set_flashdata('message','data berhasil diupdate');
            redirect(base_url('index.php/admin/user'));
        }else{
            redirect(base_url('index.php/admin/user/edit_password/' . $id));
        }
    }

    public function delete($id){
        $delete = $this->user->delete($id);
        if($delete){
            $this->session->set_flashdata('message','data berhasil dihapus');
            redirect(base_url('index.php/admin/user'));
        }else{
            redirect(base_url('index.php/admin/user/'));
        }
    }
	
	 public function username_check($str){
        $username = $this->user->check_username($str);
        if ($username){
            return true;
        }else{
            $this->form_validation->set_message('username_check', 'Username sudah terdaftar');
            return false;
        }
    }
    public function email_check($str){
        $username = $this->user->check_email($str);
        if ($username){
            return true;
        }else{
            $this->form_validation->set_message('email_check', 'Email sudah terdaftar');
            return false;
        }
    }
}