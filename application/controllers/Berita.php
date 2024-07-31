<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berita extends CI_Controller {
    
    public function __construct(){
        parent::__construct();

        $this->load->model('Berita_model','berita');

		$this->load->library('pagination');
    }

	public function index()
	{

		$config['base_url'] = base_url('index.php/berita/index/');
		$config['total_rows'] = $this->db->count_all('berita');
		$config['per_page'] = 9;
		$config['uri_segment'] = 3;

		// // Konfigurasi untuk tampilan paginasi menggunakan Bootstrap
		// $config['full_tag_open'] = '<nav><ul class="pagination">';
		// $config['full_tag_close'] = '</ul></nav>';

		// $config['first_link'] = 'First';
		// $config['first_tag_open'] = '<li class="page-item">';
		// $config['first_tag_close'] = '</li>';
			
		// $config['last_link'] = 'Last';
		// $config['last_tag_open'] = '<li class="page-item">';
		// $config['last_tag_close'] = '</li>';

		// $config['next_link'] = '&raquo;';
		// $config['next_tag_open'] = '<li class="page-item">';
		// $config['next_tag_close'] = '</li>';

		// $config['prev_link'] = '&laquo;';
		// $config['prev_tag_open'] = '<li class="page-item">';
		// $config['prev_tag_close'] = '</li>';

		// $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
		// $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';

		// $config['num_tag_open'] = '<li class="page-item">';
		// $config['num_tag_close'] = '</li>';
		
		// Inisialisasi paginasi
		$this->pagination->initialize($config);
		
		// Mendapatkan nomor halaman dari URI segment
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
		// Memanggil fungsi get_latest() dengan paginasi
		$data['berita'] = $this->berita->get_pagination($config['per_page'], $page);
		$var['title'] = 'Berita';
		$var['content'] = $this->load->view('berita/index',$data,true);

		$this->load->view('layouts/main',$var);
	}

	public function detail($id)
    {
        // Mengambil data berita berdasarkan ID
        $data['berita'] = $this->berita->get_by_id($id);

        // Memeriksa apakah data berita ada
        if (empty($data['berita'])) {
            show_404();
        }

        $var['title'] = 'Detail Berita';
        $var['content'] = $this->load->view('berita/detail_berita', $data, true);

        $this->load->view('layouts/main', $var);
    }
}
