<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends CI_Controller {

    public function __construct(){
        parent::__construct();
        if(empty($this->session->userdata('roles'))){
            redirect(base_url('index.php/auth/login'));
        }else{
            if($this->session->userdata('roles') != 'Operator'){
                redirect(base_url('index.php/auth/login'));
            }
        }
        $this->load->model('Siswa_model','siswa');
    }
    public function download(){
		if(!empty($this->input->post())){
			$where = array();
			if(!empty($this->input->post('kelas')) && $this->input->post('kelas') != 0){
				$where['kelas'] = $this->input->post('kelas');
			}
			if(!empty($this->input->post('kode')) && $this->input->post('kode') != 0){
				$where['kode'] = $this->input->post('kode');
			}
			if(!empty($this->input->post('kota'))  && $this->input->post('kota') != 0){
				$where['kabkota'] = $this->input->post('kota');
			}
			if(!empty($this->input->post('provinsi'))  && $this->input->post('provinsi') != 0){
				$where['provinsi'] = $this->input->post('provinsi');
			}
			//echo $this->input->post('kelas');
			//var_dump($where);
			
			if(empty($where)){
				$siswa = $this->db->get('tb_siswa_detail')->result();
			}else{
				$siswa = $this->db->where($where)->get('tb_siswa_detail')->result();
			}
			
			$data['siswa'] = $siswa;
			
		}else{
			$siswa = $this->db->get('tb_siswa_detail')->result();
			$data['siswa'] = $siswa;
		}
		$data['kelas'] = $this->db->group_by('kelas')->get('tb_siswa_detail')->result();
		//$data['kelas'] = $this->db->group_by('kode')->get('tb_siswa_detail')->result();
		$data['kota'] = $this->db->group_by('kabkota')->get('tb_siswa_detail')->result();
		$data['list_kota'] = array();
		$list_kota = $this->db->get('cities')->result();
		$data['list_kota'][0] = "N/A";
		foreach($list_kota as $kota){
			$data['list_kota'][$kota->city_id] = $kota->city_name;
		}
		$data['list_provinsi'] = array();
		$list_provinsi = $this->db->get('provinces')->result();
		foreach($list_provinsi as $provinsi){
			$data['list_provinsi'][$provinsi->prov_id] = $provinsi->prov_name;
		}
		$data['list_provinsi'][0] = "N/A";
		$data['provinsi'] = $this->db->group_by('provinsi')->get('tb_siswa_detail')->result();
		$var['title'] = 'Siswa';
		//$data['kode'] = $this->siswa->get_kelas_all();
		$var['content'] = $this->load->view('operator/siswa/download',$data,true);
        $var['role'] = "Operator";
		
		$this->load->view('layouts/admin',$var);
	}
    public function get_table_siswa(){
		if(!empty($this->input->post())){
			$where = array();
			if(!empty($this->input->post('kelas')) && $this->input->post('kelas') != 0){
				$where['kelas'] = $this->input->post('kelas');
			}
			if(!empty($this->input->post('kode')) && $this->input->post('kode') != 0){
				$where['kode'] = $this->input->post('kode');
			}
			if(!empty($this->input->post('kota'))  && $this->input->post('kota') != 0){
				$where['kabkota'] = $this->input->post('kota');
			}
			if(!empty($this->input->post('provinsi'))  && $this->input->post('provinsi') != 0){
				$where['provinsi'] = $this->input->post('provinsi');
			}
			//echo $this->input->post('kelas');
			//var_dump($where);
			
			if(empty($where)){
				$siswa = $this->db->get('tb_siswa_detail')->result();
			}else{
				$siswa = $this->db->where($where)->get('tb_siswa_detail')->result();
			}
			
			$data['siswa'] = $siswa;
			
		}else{
			$siswa = $this->db->get('tb_siswa_detail')->result();
			$data['siswa'] = $siswa;
		}
		//echo $this->db->last_query();
		$data['kelas'] = $this->db->group_by('kelas')->get('tb_siswa_detail')->result();
		//$data['kelas'] = $this->db->group_by('kode')->get('tb_siswa_detail')->result();
		$data['kota'] = $this->db->group_by('kabkota')->get('tb_siswa_detail')->result();
		$data['list_kota'] = array();
		$list_kota = $this->db->get('cities')->result();
		$data['list_kota'][0] = "N/A";
		foreach($list_kota as $kota){
			$data['list_kota'][$kota->city_id] = $kota->city_name;
		}
		$data['list_provinsi'] = array();
		$list_provinsi = $this->db->get('provinces')->result();
		foreach($list_provinsi as $provinsi){
			$data['list_provinsi'][$provinsi->prov_id] = $provinsi->prov_name;
		}
		$data['list_provinsi'][0] = "N/A";
		$data['provinsi'] = $this->db->group_by('provinsi')->get('tb_siswa_detail')->result();
		
		//$data['kode'] = $this->siswa->get_kelas_all();
		$this->load->view('admin/siswa/tabel_siswa',$data);
		
		//$this->load->view('layouts/admin',$var);
	}
    public function get_provinsi(){
		$kelas = $this->input->post('kelas');
		$provinsi = $this->db->where("kelas",$kelas)->group_by('provinsi')->get("tb_siswa_detail")->result();
		$list_provinsi = $this->list_provinsi();
		echo "<option value=0>---Semua---</option>";
		foreach($provinsi as $row){
			if(!empty($row->provinsi)){
				echo '<option value="' . $row->provinsi .'" ';
				/* if($row->kabkota == $this->input->post('kabkota')){
					echo "selected";
				} */
				echo '>' . $list_provinsi[$row->provinsi] . '</option>';
			}
		}
	}
	public function get_kota(){
		$id_provinsi = $this->input->post('prov_id');
		$kelas = $this->input->post('kelas');
		$kota = $this->db->where("provinsi",$id_provinsi)->where("kelas",$kelas)->group_by('kabkota')->get("tb_siswa_detail")->result();
		$list_kota = $this->list_kota();
		echo "<option value=0>---Semua---</option>";
		foreach($kota as $row){
			if(!empty($row->kabkota)){
				echo '<option value="' . $row->kabkota .'" ';
				/* if($row->kabkota == $this->input->post('kabkota')){
					echo "selected";
				} */
				echo '>' . $list_kota[$row->kabkota] . '</option>';
			}
		}
	}

    private function list_kota(){
		$kota = $this->db->get('cities')->result();
		$list_kota = array();
		foreach($kota as $row){
			$list_kota[$row->city_id] = $row->city_name;
		}
		return $list_kota;
	}
	private function list_provinsi(){
		$provinsi = $this->db->get('provinces')->result();
		$list_provinsi = array();
		foreach($provinsi as $row){
			$list_provinsi[$row->prov_id] = $row->prov_name;
		}
		return $list_provinsi;
	}
}