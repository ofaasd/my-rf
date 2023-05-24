<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct(){
        parent::__construct();

        $this->load->model('User_model','user');

    }

    public function login(){

        $data['array'] = '';
		$var['title'] = 'PPATQ Roudlotul Falah';
		$var['content'] = $this->load->view('auth/login',$data,true);

		$this->load->view('layouts/main',$var);
    }
    public function proses_login(){
        $this->load->model('User_model','user');
        $hasil = $this->user->verification();
        if($hasil){
            
            if( $this->session->userdata('roles') == 'Admin') redirect(base_url('index.php/admin/dashboard'));
            elseif($this->session->userdata('roles') == 'Operator') redirect(base_url('index.php/operator/dashboard'));
            else redirect(base_url('/'));
            
        }else{
            $this->session->set_flashdata('error','Username / Password salah !');
            redirect(base_url('/index.php/auth/login'));
        }
    }
    public function register(){
        //load helper form
        $this->load->helper(array('form', 'url'));
        //load library form validation
        $this->load->library('form_validation');


        $data['array'] = '';
		$var['title'] = 'PPATQ Roudlotul Falah';
		$var['content'] = $this->load->view('auth/register',$data,true);

		$this->load->view('layouts/main',$var);
    }
    public function proses_register(){
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'name', 'required');
        $this->form_validation->set_rules('username', 'Username', 'callback_username_check');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        $this->form_validation->set_rules('password-confirm', 'Password Confirmation', 'required|matches[password]');
        $this->form_validation->set_rules('email', 'Email', 'callback_email_check');
        if ($this->form_validation->run() == FALSE)
        {
            $data['array'] = '';
            $var['title'] = 'PPATQ Roudlotul Falah';
            $var['content'] = $this->load->view('auth/register',$data,true);
    
            $this->load->view('layouts/main',$var);
        }
        else
        {
            $register = $this->user->register();
            if($register){
                $this->session->set_flashdata('message','Pendaftaran Berhasil Silahkan Login Kembali');
                redirect(base_url('/index.php/auth/login'));
            }else{
                $this->session->set_flashdata('message','Data Gagal di input');
                redirect(base_url('/index.php/auth/register'));
            }
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
    public function logout(){
        $this->session->sess_destroy();
        redirect(base_url('/'));
    }
}