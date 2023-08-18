<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keluhan extends CI_Controller {

    public function __construct(){
        parent::__construct();
        if(empty($this->session->userdata('roles'))){
            redirect(base_url('index.php/auth/login'));
        }else{
            if($this->session->userdata('roles') != 'Admin'){
                redirect(base_url('index.php/auth/login'));
            }
        }
        $this->load->model('Keluhan_model','keluhan');
        $this->load->model('Siswa_model','siswa');
    }

    public function index(){
		
        $data['keluhan'] = $this->keluhan->get_all();

		$var['title'] = 'Daftar Keluhan';
        $data['list_siswa'] = $this->siswa->list_siswa_ni();
		$var['content'] = $this->load->view('admin/keluhan/index',$data,true);

		$this->load->view('layouts/admin',$var);
    }
    public function show($id){
		
        $data['keluhan'] = $this->keluhan->get_by_id($id);
        $data['siswa'] = $this->siswa->get_by_ni($data['keluhan']->id_santri);

		$var['title'] = 'Detail Keluhan';
		$var['content'] = $this->load->view('admin/keluhan/show',$data,true);

		$this->load->view('layouts/admin',$var);
    }
	public function delete($id){
        $delete = $this->keluhan->delete($id);
        if($delete){
            $this->session->set_flashdata('message','data berhasil dihapus');
            redirect(base_url('index.php/admin/keluhan'));
        }else{
			$this->session->set_flashdata('error','data gagal dihapus');
            redirect(base_url('index.php/admin/keluhan/'));
        }
    }
    public function migrasi_noinduk(){
        $keluhan = $this->keluhan->get_all();
        foreach($keluhan as $row){
            $santri = $this->siswa->get_by_id($row->id_santri);
            if(!empty($santri->no_induk)){
                echo $santri->no_induk;
                echo $row->id_santri;
                echo "<br />";
                $data = array(
                    'id_santri' => $santri->no_induk,
                );
                $update = $this->db->update('tb_keluhan',$data,array('id'=>$row->id));
                if($update){
                    echo "berhasil";
                }else{
                    echo "gagal";
                }

                echo "<br />";
            }
        }
    }
	public function laporan(){
		if(!empty($this->input->post('date_start'))){
            $start = $this->input->post('date_start');
            $end = $this->input->post('date_end');
			$data['keluhan'] = $this->keluhan->get_by_date($start,$end);

			$data['list_siswa'] = $this->siswa->list_siswa_ni();
            $data['date_start'] = $start;
            $data['date_end'] = $end;
            $var['title'] = 'Keluhan ' . date('d-m-Y', strtotime($start)) . ' - ' . date('d-m-Y', strtotime($end));
            $var['content'] = $this->load->view('admin/keluhan/laporan',$data,true);

            $this->load->view('layouts/admin',$var);
        }else{
            $data = '';
            $var['title'] = 'Laporan Keluhan';
            $var['content'] = $this->load->view('admin/keluhan/laporan',$data,true);

            $this->load->view('layouts/admin',$var);
        }
	}
}
