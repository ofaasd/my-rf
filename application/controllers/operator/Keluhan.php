<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keluhan extends CI_Controller {

    public function __construct(){
        parent::__construct();
        if(empty($this->session->userdata('roles'))){
            redirect(base_url('index.php/auth/login'));
        }else{
            if($this->session->userdata('roles') != 'Operator'){
                redirect(base_url('index.php/auth/login'));
            }
        }
        $this->load->model('Keluhan_model','keluhan');
    }

    public function index(){
		
        $data['keluhan'] = $this->keluhan->get_all();

		$var['title'] = 'Daftar Keluhan';
		$var['content'] = $this->load->view('operator/keluhan/index',$data,true);
		$var['role'] = "Operator";

		$this->load->view('layouts/admin',$var);
    }
    public function show($id){
		
        $data['keluhan'] = $this->keluhan->get_by_id($id);

		$var['title'] = 'Detail Keluhan';
		$var['content'] = $this->load->view('operator/keluhan/show',$data,true);
        $var['role'] = "Operator";

		$this->load->view('layouts/admin',$var);
    }
}