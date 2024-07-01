<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berita extends CI_Controller {
    
    public function __construct(){
        parent::__construct();

        $this->load->model('Berita_model','berita');

    }

	public function index()
	{
        $data['berita'] = $this->berita->get_all();
		$var['title'] = 'Berita';
		$var['content'] = $this->load->view('berita/index',$data,true);

		$this->load->view('layouts/main',$var);
	}
}
