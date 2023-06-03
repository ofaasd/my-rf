<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
		
        $this->load->model('Siswa_model','siswa');
		if(empty($this->session->userdata('pwd'))){
			$this->session->set_flashdata('error','Harap isi form ini terlebih dahulu');
			redirect(base_url('index.php/pembayaran/index_profile'));
		}

    }
	public $bulan = array(1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');

	public function index()
	{
		$siswa = $this->siswa->get_by_id($this->session->userdata('siswa_id'));
        $data['siswa'] = $this->db->where('no_induk',$siswa->no_induk)->get('tb_siswa_detail')->row();
		$data['provinsi'] = $this->db->get('provinces')->result();
		$data['prov_curr']  = $this->db->where('prov_id',$data['siswa']->provinsi)->get('provinces')->row();
		$data['kota'] = $this->db->where('prov_id',$data['siswa']->provinsi)->get('cities')->result();
		$data['kota_curr']  = $this->db->where('city_id',$data['siswa']->kabkota)->get('cities')->row();
        
		$var['title'] = 'PPATQ Roudlotul Falah';
		$var['content'] = $this->load->view('profile/index',$data,true);


		$this->load->view('layouts/main',$var);
	}
	
	public function get_kota(){
		$id_provinsi = $this->input->post('prov_id');
		$kota = $this->db->where('prov_id',$id_provinsi)->get('cities')->result();
		foreach($kota as $row){
			echo '<option value="' . $row->city_id .'" ';
			echo '>' . $row->city_name . '</option>';
		
		}
	}
	public function simpan(){
        $update = $this->siswa->update_siswa_detail();
        if($update){
            $this->session->set_flashdata('message','data berhasil diupdate');
            redirect(base_url('index.php/profile/index'));
        }else{
            redirect(base_url('index.php/profile/index'));
        }
	}
}
?>