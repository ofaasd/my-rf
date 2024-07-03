<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends CI_Controller {

    public function __construct(){
        parent::__construct();
        if(empty($this->session->userdata('roles'))){
            redirect(base_url('index.php/auth/login'));
        }else{
            if($this->session->userdata('roles') != 'Admin'){
                redirect(base_url('index.php/auth/login'));
            }
        }
        $this->load->model('Siswa_model','siswa');
    }

    public function index(){
		
        $data['siswa'] = $this->siswa->get_all_order_kelas();

		$var['title'] = 'Siswa';
		$data['list_kelas'] = array('1a','1b','2a','2b','3a','3b','4a','4b','5a','5b','6a','6b');
		$data['kode'] = $this->siswa->get_kelas_all();
		$data['kode_1a'] = $this->siswa->get_kode_1a();
		$data['kode_1b'] = $this->siswa->get_kode_1b();
		$var['content'] = $this->load->view('admin/siswa/index',$data,true);
		
		$this->load->view('layouts/admin',$var);
    }

    public function create(){

        $data['siswa'] = '';

		$var['title'] = 'Tambah Siswa';
		$var['content'] = $this->load->view('admin/siswa/create',$data,true);

		$this->load->view('layouts/admin',$var);
    }

    
    public function edit($id){

        $data['siswa'] = $this->siswa->get_by_id($id);

		$var['title'] = 'Edit Siswa';
		$var['content'] = $this->load->view('admin/siswa/create',$data,true);

		$this->load->view('layouts/admin',$var);
    }

    public function insert(){
        $insert = $this->siswa->insert();
        if($insert){
            $this->session->set_flashdata('message','data berhasil ditambahkan');
            redirect(base_url('index.php/admin/siswa'));
        }else{
            redirect(base_url('index.php/admin/siswa/create'));
        }
    }

    public function update(){
        $update = $this->siswa->update();
        if($update){
            $this->session->set_flashdata('message','data berhasil diupdate');
            redirect(base_url('index.php/admin/siswa'));
        }else{
            redirect(base_url('index.php/admin/siswa/edit/' . $id));
        }
    }

    public function delete($id){
        $delete = $this->siswa->delete($id);
        if($delete){
            $this->session->set_flashdata('message','data berhasil dihapus');
            redirect(base_url('index.php/admin/siswa'));
        }else{
            redirect(base_url('index.php/admin/siswa/'));
        }
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
		$var['content'] = $this->load->view('admin/siswa/download',$data,true);
		
		$this->load->view('layouts/admin',$var);
	}
	public function download2(){
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
		$var['content'] = $this->load->view('admin/siswa/download2',$data,true);
		
		$this->load->view('layouts/admin',$var);
	}

    public function import(){
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('list_siswa', 'Daftar Siswa', 'required');
        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error','File yang anda masukan belum sesuai format');
            redirect(base_url('/index.php/admin/siswa'));
        }else{
            $list_siswa = $this->input->post('list_siswa');
            $hasil = json_decode($list_siswa);
            $insert = $this->siswa->insert_json_detail($hasil);
            if($insert){
                $this->session->set_flashdata('message','data berhasil ditambahkan');
                redirect(base_url('index.php/admin/siswa'));
            }else{
                $this->session->set_flashdata('error','Data gagal masuk ke database');
                redirect(base_url('index.php/admin/siswa/create'));
            }
        }
    }
	public function compare_siswa(){
		//$siswa = $this->db->get("ref_siswa");
		/* $siswa_detail = $this->db->get("tb_siswa_detail")->result();
		foreach($siswa_detail as $row){
			$siswa = $this->db->where('LOWER(nama)',strtolower($row->nama))->get('ref_siswa');
			if($siswa->num_rows()){
				$hasil = $siswa->row();
				$data = array(
					'no_induk' => $row->no_induk,
				);
				$update = $this->db->update('ref_siswa',$data,array('id'=>$hasil->id));
				if($update){
					echo "berhasil";
				}
			}
		} */
		$cek = $this->db->where('no_induk',0)->get('ref_siswa')->num_rows();
		echo $cek;
	}
	public function siswa_baru(){
		
		$data['siswa'] = $this->db->get('tb_siswa_detail')->result();

		$var['title'] = 'Siswa';
		$data['kode'] = $this->siswa->get_kelas_all();
		$var['content'] = $this->load->view('admin/siswa/index2',$data,true);
		
		$this->load->view('layouts/admin',$var);
	}
	//code Normalisasi kode kota dan provinsi pada data siswa yang baru
	public function siswa_origin(){
		$data['siswa'] = $this->db->get('tb_siswa_detail')->result();
		//$data['kota'] = $this->db->get('cities')->result();
		$hitung = 0;
		$hitung_salah = 0;
		//cari kota yang belum ada di database;
		$kota = $this->db->get('tb_siswa_detail')->result();
		foreach($kota as $row){
			//echo strtolower($row->kabkota);
			if(!is_numeric($row->provinsi)){
				echo $row->kabkota;
				echo "<br />";
			}
		} 
		/* foreach($data['siswa'] as $siswa){
			$kota = trim(substr($siswa->kabkota, 4));
			//$kota = $siswa->kabkota;
			$cities = $this->db->where('LOWER(city_name)',strtolower($kota))->get('cities');
			//echo $siswa->kabkota . "=" . $cities->row()->city_name . " ";
			$num_row = $cities->num_rows();
			if($num_row == 1){
				$data = array(
					'kabkota' => $cities->row()->city_id,
				);
				$where = array(
					'id' => $siswa->id,
				);
				print_r($data);
				print_r($where);
				echo "<br />";	
				$update = $this->db->update('tb_siswa_detail',$data,$where);
				$hitung++;
			}else{
				$hitung_salah++;
			}
			//echo $num_row . "<br />";
		} */
		
		//check district
		/* foreach($data['siswa'] as $siswa){
			$kota = $siswa->kabkota;
			$districts = $this->db->where('LOWER(dis_name)',strtolower($kota))->get('districts');
			//echo $siswa->kabkota . "=" . $cities->row()->city_name . " ";
			$num_row = $districts->num_rows();
			if($num_row == 1){
				$data = array(
					'kabkota' => $districts->row()->city_id,
				);
				$where = array(
					'id' => $siswa->id,
				);
				print_r($data);
				print_r($where);
				echo "<br />";	
				$update = $this->db->update('tb_siswa_detail',$data,$where);
				$hitung++;
			}else{
				$hitung_salah++;
			}
			//echo $num_row . "<br />";
		} */
		
		//update provinsi 
		foreach($data['siswa'] as $siswa){
			$kota = $siswa->kabkota;
			$city = $this->db->where('city_id',$kota)->get('cities');
			//echo $siswa->kabkota . "=" . $cities->row()->city_name . " ";
			$num_row = $city->num_rows();
			if($num_row == 1){
				$data = array(
					'provinsi' => $city->row()->prov_id,
				);
				$where = array(
					'id' => $siswa->id,
				);
				print_r($data);
				print_r($where);
				echo "<br />";	
				$update = $this->db->update('tb_siswa_detail',$data,$where);
				$hitung++;
			}else{
				$hitung_salah++;
			}
			//echo $num_row . "<br />";
		}
		/* echo $hitung;
		echo "<br />";
		echo $hitung_salah; */
		exit;
		$var['title'] = 'Siswa';
		$data['kode'] = $this->siswa->get_kelas_all();
		$var['content'] = $this->load->view('admin/siswa/index2',$data,true);
		
		$this->load->view('layouts/admin',$var);
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
	public function get_table_siswa2(){
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
		$this->load->view('admin/siswa/table_siswa2',$data);
		
		//$this->load->view('layouts/admin',$var);
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
	public function show($no_induk){
		//$siswa = $this->siswa->get_by_id($this->session->userdata('siswa_id'));
        $data['siswa'] = $this->db->where('no_induk',$no_induk)->get('tb_siswa_detail')->row();
		$data['provinsi'] = $this->db->get('provinces')->result();
		$data['prov_curr']  = $this->db->where('prov_id',$data['siswa']->provinsi)->get('provinces')->row();
		$data['kota'] = $this->db->where('prov_id',$data['siswa']->provinsi)->get('cities')->result();
		$data['kota_curr']  = $this->db->where('city_id',$data['siswa']->kabkota)->get('cities')->row();
        
		$var['title'] = 'PPATQ Roudlotul Falah';
		$var['content'] = $this->load->view('admin/siswa/show',$data,true);
		
		$this->load->view('layouts/admin',$var);
	}
	public function simpan_detail(){
        $update = $this->siswa->update_siswa_detail();
        if($update){
            $this->session->set_flashdata('message','data berhasil diupdate');
            redirect(base_url('index.php/admin/siswa/index'));
        }else{
            redirect(base_url('index.php/admin/siswa/show/' . $this->input->post('no_induk')));
        }
	}
	public function naik_kelas(){
		$angkatan_kelulusan  = date('Y');
		$siswa = $this->siswa->get_all_detail();
		foreach($siswa as $row){
			//buat kelas baru
			$kelas = substr($row->kelas,0,1);
			$new_kelas = (int)$kelas+1;
			//simpan kode
			$kode = substr($row->kelas,1,1);
			if($new_kelas > 6){
				//insert ke tb_alumni
				//echo $row->no_induk;
				//insert ke tb_alumni
				// $data = array(
				// 	//'kode' => $new_kelas . $kode,
				// 	'no_induk' => $row->no_induk,
				// 	'nama' => $row->nama,
				// 	'nisn' => $row->nisn,
				// 	'nik' => $row->nik,
				// 	'anak_ke' => $row->anak_ke,
				// 	'tempat_lahir' => $row->tempat_lahir,
				// 	'tanggal_lahir' => $row->tanggal_lahir,
				// 	'usia' => $row->usia,
				// 	'jenis_kelamin' => $row->jenis_kelamin,
				// 	'alamat' => $row->alamat,
				// 	'kelurahan' => $row->kelurahan,
				// 	'kecamatan' => $row->kecamatan,
				// 	'kabkota' => $row->kabkota,
				// 	'provinsi' => $row->provinsi,
				// 	'kode_pos' => $row->kode_pos,
				// 	'nik_kk' => $row->nik_kk,
				// 	'nama_lengkap_ayah' => $row->nama_lengkap_ayah,
				// 	'pendidikan_ayah' => $row->pendidikan_ayah,
				// 	'pekerjaan_ayah' => $row->pekerjaan_ayah,
				// 	'nama_lengkap_ibu' => $row->nama_lengkap_ibu,
				// 	'pendidikan_ibu' => $row->pendidikan_ibu,
				// 	'pekerjaan_ibu' => $row->pekerjaan_ibu,
				// 	'no_hp' => $row->no_hp,
				// 	'created_at' => $row->created_at,
				// 	'updated_at' => $row->updated_at,
				// 	'no_tes' => $row->no_tes,
				// 	'kelas' => $row->kelas,
				// 	'kamar_id' => $row->kamar_id,
				// 	'tahfidz_id' => $row->tahfidz_id,
				// 	'photo' => $row->photo,
				// 	'photo_location' => $row->photo_location,
				// 	'deleted_at' => $row->deleted_at,
				// 	'status' => $row->status,
				// );
				$data = array(
					'deleted_at' => date('Y-m-d H:i:s')
				);
				$where = array(
					'id' => $row->id,
				);
				$update_alumni = $this->db->update('santri_detail',$data,$where);

				// //hapus dari ref_siswa 
				//$delete_siswa = $this->db->delete('santri_detail',array('id'=>$row->id));
				// //update siswa detail kelas yang kelas 6 jadi tahun alumni
				$data2 = array(
					'deleted_at' => strtotime(date('Y-m-d H:i:s'))
				);
				$update2 = $this->db->update('ref_siswa',$data2,array('no_induk'=>$row->no_induk));

				
			}else{
				//update ke db siswa dan detail siswa
				$data = array(
					'kelas' => $new_kelas . $kode,
				);
				$where = array(
					'id' => $row->id,
				);
				$update = $this->db->update('santri_detail',$data,$where);
				$data2 = array(
					'kode' => $new_kelas . $kode,
				);
				$where2 = array(
					'no_induk' => $row->no_induk,
				);
				$update = $this->db->update('ref_siswa',$data2,$where2);
			}
		}
		$this->session->set_flashdata('message','data Naik kelas berhasil diupdate');
		redirect(base_url('index.php/admin/siswa/index'));
	}
	public function adjust_kelas(){
		$siswa = $this->db->get('tb_siswa_detail')->result();
		foreach($siswa as $row){
			$kelas = substr($row->kelas,0,1);
			$new_kelas = (int)$kelas+1;
			//simpan kode
			$kode = substr($row->kelas,1,1);
			$data2 = array();
			if($new_kelas > 6){
				$data2 = array(
					'kelas' => date('Y') . $kode,
				);
			}else{
				$data2 = array(
					'kelas' => $new_kelas . $kode,
				);
			}
			
			$where2 = array(
				'no_induk' => $row->no_induk,
			);
			$update = $this->db->update('tb_siswa_detail',$data2,$where2);
		}
		$this->session->set_flashdata('message','data Naik kelas berhasil diupdate');
		redirect(base_url('index.php/admin/siswa/index'));
	}
	public function migrasi_no_induk(){
		$siswa = $this->db->where('no_induk',0)->get('ref_siswa')->result();
		foreach($siswa as $row){
			$detail = $this->db->where('nama',$row->nama)->get('tb_siswa_detail')->row();
			echo $row->nama;
			echo " ";
			$num_row = $this->db->where('nama',$row->nama)->get('tb_siswa_detail')->num_rows();
			echo $detail->no_induk;
			
			$data = array(
				'no_induk' => $detail->no_induk,
			);
			var_dump($data);
			echo "<br />";
			$update = $this->db->update('ref_siswa',$data,array('id'=>$row->id));
		}
	}
	public function hapus_angkatan_lama(){
		$alumni = $this->db->get('tb_alumni')->result();
		foreach($alumni as $row){
			if($this->db->where('no_induk',$row->no_induk)->get('ref_siswa')->num_rows() > 0){
				$hapus = $this->db->delete('ref_siswa',array('no_induk'=>$row->no_induk));
				echo "terhapus";
			}else{
				echo "aman";
			}
			//pindahkan ke tb+alumni_detail
			$siswa_detail = $this->db->where('no_induk',$row->no_induk)->get('tb_siswa_detail');
			if($siswa_detail->num_rows() > 0){
				$row = $siswa_detail->row();
				$data = array(
					'no_induk' => $row->no_induk,
					'nama' => $row->nama,
					'nisn' => $row->nisn,
					'nik' => $row->nik,
					'anak_ke' => $row->anak_ke, 
					'tempat_lahir' => $row->tempat_lahir,
					'tanggal_lahir' => $row->tanggal_lahir,
					'usia' => $row->usia,
					'jenis_kelamin' => $row->jenis_kelamin,
					'alamat' => $row->alamat,
					'kelurahan' => $row->kelurahan,
					'kecamatan' => $row->kecamatan,
					'kabkota' => $row->kabkota,
					'provinsi' => $row->provinsi,
					'kode_pos' => $row->kode_pos,
					'nik_kk' => $row->nik_kk,
					'nama_lengkap_ayah' => $row->nama_lengkap_ayah,
					'pendidikan_ayah' => $row->pendidikan_ayah,
					'pekerjaan_ayah' => $row->pekerjaan_ayah,
					'nama_lengkap_ibu' => $row->nama_lengkap_ibu,
					'pendidikan_ibu' => $row->pendidikan_ibu,
					'pekerjaan_ibu' => $row->pekerjaan_ibu,
					'no_hp' => $row->no_hp,
					'kelas' => $row->kelas,
				);
				if($this->db->insert('tb_alumni_detail',$data)){
					$hapus = $this->db->delete('tb_siswa_detail',array('no_induk'=>$row->no_induk));
				}
				echo "-berhasil migrasi-";
			}else{
				echo "aman - migrasi - ";
			}
			echo $row->nama;
			echo "<br />";
		}
	}


}
